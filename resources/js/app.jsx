import './bootstrap';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import React from "react";
import ReactDOM from "react-dom/client";
import UserPage from "./components/UserPage.jsx";

const appRoot = document.getElementById("app");
if (appRoot) {
    ReactDOM.createRoot(appRoot).render(
        <React.StrictMode>
            <UserPage />
        </React.StrictMode>
    );
}

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
