import { useEffect, useRef } from 'react';

export default function GridScan({
    lineColor = '#FF4500',
    glowColor = 'rgba(255,69,0,0.18)',
    backgroundColor = 'rgba(8,8,10,0.92)',
    cellSize = 28,
    speed = 0.9,
    className = '',
    style,
}) {
    const canvasRef = useRef(null);

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return undefined;
        const ctx = canvas.getContext('2d');
        if (!ctx) return undefined;

        let rafId = 0;
        let scanY = 0;

        const resize = () => {
            const parent = canvas.parentElement;
            if (!parent) return;
            const rect = parent.getBoundingClientRect();
            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            canvas.width = Math.max(1, Math.floor(rect.width * dpr));
            canvas.height = Math.max(1, Math.floor(rect.height * dpr));
            canvas.style.width = `${rect.width}px`;
            canvas.style.height = `${rect.height}px`;
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            scanY = 0;
        };

        const drawGrid = (width, height) => {
            ctx.fillStyle = backgroundColor;
            ctx.fillRect(0, 0, width, height);

            ctx.strokeStyle = 'rgba(255,69,0,0.16)';
            ctx.lineWidth = 1;
            for (let x = 0; x < width; x += cellSize) {
                ctx.beginPath();
                ctx.moveTo(x + 0.5, 0);
                ctx.lineTo(x + 0.5, height);
                ctx.stroke();
            }
            for (let y = 0; y < height; y += cellSize) {
                ctx.beginPath();
                ctx.moveTo(0, y + 0.5);
                ctx.lineTo(width, y + 0.5);
                ctx.stroke();
            }
        };

        const render = () => {
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;
            drawGrid(width, height);

            const bandHeight = Math.max(36, cellSize * 1.2);
            scanY += speed;
            if (scanY > height + bandHeight) scanY = -bandHeight;

            const gradient = ctx.createLinearGradient(0, scanY - bandHeight, 0, scanY + bandHeight);
            gradient.addColorStop(0, 'rgba(255,69,0,0)');
            gradient.addColorStop(0.5, glowColor);
            gradient.addColorStop(1, 'rgba(255,69,0,0)');

            ctx.fillStyle = gradient;
            ctx.fillRect(0, scanY - bandHeight, width, bandHeight * 2);

            ctx.strokeStyle = lineColor;
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(0, scanY + 0.5);
            ctx.lineTo(width, scanY + 0.5);
            ctx.stroke();

            rafId = requestAnimationFrame(render);
        };

        resize();
        render();
        window.addEventListener('resize', resize);

        return () => {
            cancelAnimationFrame(rafId);
            window.removeEventListener('resize', resize);
        };
    }, [backgroundColor, cellSize, glowColor, lineColor, speed]);

    return (
        <div className={`w-full h-full relative overflow-hidden ${className}`} style={style}>
            <canvas ref={canvasRef} className="w-full h-full block" aria-label="Grid scan animated background" />
        </div>
    );
}
