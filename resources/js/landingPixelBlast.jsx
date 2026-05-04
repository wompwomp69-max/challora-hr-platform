import React from 'react';
import { createRoot } from 'react-dom/client';
import GridScan from './components/GridScan';

function mountLandingPixelBlast() {
    const target = document.getElementById('rb-pixelblast-react-root');
    if (!target) return;

    const root = createRoot(target);
    root.render(
        <GridScan
            lineColor="#FF4500"
            glowColor="rgba(255,69,0,0.2)"
            backgroundColor="rgba(8,8,10,0.92)"
            cellSize={28}
            speed={1}
            className="rb-pixelblast-react-canvas"
        />,
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountLandingPixelBlast);
} else {
    mountLandingPixelBlast();
}
