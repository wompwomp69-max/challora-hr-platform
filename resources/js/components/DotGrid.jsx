import { useRef, useEffect, useCallback, useMemo } from 'react';
import { gsap } from 'gsap';

const throttle = (func, limit) => {
    let lastCall = 0;
    return (...args) => {
        const now = performance.now();
        if (now - lastCall >= limit) {
            lastCall = now;
            func(...args);
        }
    };
};

function hexToRgb(hex) {
    const m = hex.match(/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i);
    if (!m) return { r: 0, g: 0, b: 0 };
    return {
        r: parseInt(m[1], 16),
        g: parseInt(m[2], 16),
        b: parseInt(m[3], 16),
    };
}

export default function DotGrid({
    dotSize = 5,
    gap = 15,
    baseColor = '#2F293A',
    activeColor = '#5227FF',
    proximity = 120,
    speedTrigger = 100,
    shockRadius = 250,
    shockStrength = 5,
    maxSpeed = 5000,
    resistance = 750,
    returnDuration = 1.5,
    className = '',
    style,
}) {
    const wrapperRef = useRef(null);
    const canvasRef = useRef(null);
    const dotsRef = useRef([]);
    const pointerRef = useRef({
        x: 0,
        y: 0,
        vx: 0,
        vy: 0,
        speed: 0,
        lastTime: 0,
        lastX: 0,
        lastY: 0,
    });

    const baseRgb = useMemo(() => hexToRgb(baseColor), [baseColor]);
    const activeRgb = useMemo(() => hexToRgb(activeColor), [activeColor]);

    const circlePath = useMemo(() => {
        if (typeof window === 'undefined' || !window.Path2D) return null;
        const p = new Path2D();
        p.arc(0, 0, dotSize / 2, 0, Math.PI * 2);
        return p;
    }, [dotSize]);

    const buildGrid = useCallback(() => {
        const wrap = wrapperRef.current;
        const canvas = canvasRef.current;
        if (!wrap || !canvas) return;

        const { width, height } = wrap.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        canvas.width = Math.max(1, width * dpr);
        canvas.height = Math.max(1, height * dpr);
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;

        const ctx = canvas.getContext('2d');
        if (ctx) ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        const cols = Math.floor((width + gap) / (dotSize + gap));
        const rows = Math.floor((height + gap) / (dotSize + gap));
        const cell = dotSize + gap;
        const gridW = cell * cols - gap;
        const gridH = cell * rows - gap;
        const startX = (width - gridW) / 2 + dotSize / 2;
        const startY = (height - gridH) / 2 + dotSize / 2;

        const dots = [];
        for (let y = 0; y < rows; y++) {
            for (let x = 0; x < cols; x++) {
                const cx = startX + x * cell;
                const cy = startY + y * cell;
                dots.push({ cx, cy, xOffset: 0, yOffset: 0, targetX: 0, targetY: 0, _shock: false });
            }
        }
        dotsRef.current = dots;
    }, [dotSize, gap]);

    useEffect(() => {
        if (!circlePath) return undefined;
        let rafId;
        const proxSq = proximity * proximity;

        const draw = () => {
            const canvas = canvasRef.current;
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            const { x: px, y: py } = pointerRef.current;

            for (const dot of dotsRef.current) {
                // Lightweight follow animation: lerp offsets each frame.
                if (!dot._shock) {
                    dot.xOffset += (dot.targetX - dot.xOffset) * 0.2;
                    dot.yOffset += (dot.targetY - dot.yOffset) * 0.2;
                }

                const ox = dot.cx + dot.xOffset;
                const oy = dot.cy + dot.yOffset;
                const dx = dot.cx - px;
                const dy = dot.cy - py;
                const dsq = dx * dx + dy * dy;

                let fill = baseColor;
                if (dsq <= proxSq) {
                    const dist = Math.sqrt(dsq);
                    const t = 1 - dist / proximity;
                    const r = Math.round(baseRgb.r + (activeRgb.r - baseRgb.r) * t);
                    const g = Math.round(baseRgb.g + (activeRgb.g - baseRgb.g) * t);
                    const b = Math.round(baseRgb.b + (activeRgb.b - baseRgb.b) * t);
                    fill = `rgb(${r},${g},${b})`;
                }

                ctx.save();
                ctx.translate(ox, oy);
                ctx.fillStyle = fill;
                ctx.fill(circlePath);
                ctx.restore();
            }

            rafId = requestAnimationFrame(draw);
        };

        draw();
        return () => cancelAnimationFrame(rafId);
    }, [proximity, baseColor, baseRgb, activeRgb, circlePath]);

    useEffect(() => {
        buildGrid();
        let ro = null;
        if ('ResizeObserver' in window) {
            ro = new ResizeObserver(buildGrid);
            if (wrapperRef.current) ro.observe(wrapperRef.current);
        } else {
            window.addEventListener('resize', buildGrid);
        }
        return () => {
            if (ro) ro.disconnect();
            else window.removeEventListener('resize', buildGrid);
        };
    }, [buildGrid]);

    useEffect(() => {
        const onMove = (e) => {
            const canvas = canvasRef.current;
            if (!canvas) return;

            const now = performance.now();
            const pr = pointerRef.current;
            const dt = pr.lastTime ? now - pr.lastTime : 16;
            const dx = e.clientX - pr.lastX;
            const dy = e.clientY - pr.lastY;
            let vx = (dx / dt) * 1000;
            let vy = (dy / dt) * 1000;
            let speed = Math.hypot(vx, vy);

            if (speed > maxSpeed) {
                const scale = maxSpeed / speed;
                vx *= scale;
                vy *= scale;
                speed = maxSpeed;
            }

            pr.lastTime = now;
            pr.lastX = e.clientX;
            pr.lastY = e.clientY;
            pr.vx = vx;
            pr.vy = vy;
            pr.speed = speed;

            const rect = canvas.getBoundingClientRect();
            pr.x = e.clientX - rect.left;
            pr.y = e.clientY - rect.top;

            for (const dot of dotsRef.current) {
                const dist = Math.hypot(dot.cx - pr.x, dot.cy - pr.y);
                if (dot._shock) continue;

                if (dist < proximity) {
                    const falloff = 1 - dist / proximity;
                    const dirX = dot.cx - pr.x;
                    const dirY = dot.cy - pr.y;
                    dot.targetX = (dirX * 0.12 + vx * 0.0038) * falloff;
                    dot.targetY = (dirY * 0.12 + vy * 0.0038) * falloff;
                } else {
                    dot.targetX = 0;
                    dot.targetY = 0;
                }
            }
        };

        const onClick = (e) => {
            const canvas = canvasRef.current;
            if (!canvas) return;
            const rect = canvas.getBoundingClientRect();
            const cx = e.clientX - rect.left;
            const cy = e.clientY - rect.top;

            for (const dot of dotsRef.current) {
                const dist = Math.hypot(dot.cx - cx, dot.cy - cy);
                if (dist < shockRadius && !dot._shock) {
                    dot._shock = true;
                    gsap.killTweensOf(dot);
                    dot.targetX = 0;
                    dot.targetY = 0;
                    const falloff = Math.max(0, 1 - dist / shockRadius);
                    const pushX = (dot.cx - cx) * shockStrength * falloff;
                    const pushY = (dot.cy - cy) * shockStrength * falloff;
                    gsap.to(dot, {
                        xOffset: pushX,
                        yOffset: pushY,
                        duration: Math.max(0.12, resistance / 5000),
                        ease: 'power3.out',
                        onComplete: () => {
                            gsap.to(dot, {
                                xOffset: 0,
                                yOffset: 0,
                                duration: returnDuration,
                                ease: 'elastic.out(1,0.75)',
                                onComplete: () => {
                                    dot._shock = false;
                                },
                            });
                        },
                    });
                }
            }
        };

        const throttledMove = throttle(onMove, 28);
        window.addEventListener('mousemove', throttledMove, { passive: true });
        window.addEventListener('click', onClick);

        return () => {
            window.removeEventListener('mousemove', throttledMove);
            window.removeEventListener('click', onClick);
        };
    }, [maxSpeed, speedTrigger, proximity, resistance, returnDuration, shockRadius, shockStrength]);

    return (
        <section className={`w-full h-full relative ${className}`} style={style}>
            <div ref={wrapperRef} className="w-full h-full relative">
                <canvas ref={canvasRef} className="absolute inset-0 w-full h-full pointer-events-none" />
            </div>
        </section>
    );
}
