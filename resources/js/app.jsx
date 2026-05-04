import './bootstrap';
import './landingPixelBlast';
import './authDotGrid';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swup from 'swup';
import SwupScriptsPlugin from '@swup/scripts-plugin';
import SwupFormsPlugin from '@swup/forms-plugin';
import SwupHeadPlugin from '@swup/head-plugin';
import React from "react";
import ReactDOM from "react-dom/client";
import UserPage from "./components/UserPage.jsx";

ReactDOM.createRoot(document.getElementById("app")).render(
  <React.StrictMode>
    <UserPage />
  </React.StrictMode>
);

gsap.registerPlugin(ScrollTrigger);

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

document.addEventListener('DOMContentLoaded', () => {
    window.swup = new Swup({
        plugins: [
            new SwupScriptsPlugin({ head: true, body: true }),
            new SwupFormsPlugin(),
            new SwupHeadPlugin({
                awaitAssets: true
            })
        ]
    });
});
