import React from 'react';
import { createRoot } from 'react-dom/client';
import PixelBlast from './components/PixelBlast';

function mountAuthDotGrid() {
    const target = document.getElementById('auth-dotgrid-react-root');
    if (!target) return;

    const root = createRoot(target);
    root.render(
        <PixelBlast
            variant="square"
            pixelSize={3}
            color="#FF4500"
            patternScale={1.9}
            patternDensity={0.95}
            pixelSizeJitter={0}
            enableRipples
            rippleSpeed={0.28}
            rippleThickness={0.1}
            rippleIntensityScale={1.05}
            liquid={false}
            speed={0.45}
            edgeFade={0.2}
            transparent
            className="auth-dotgrid-canvas-layer"
        />,
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountAuthDotGrid);
} else {
    mountAuthDotGrid();
}
