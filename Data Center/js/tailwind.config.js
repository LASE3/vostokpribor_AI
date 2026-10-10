/**
 * VOSTOKPRIBOR AI • SYS-AI-02: DATA CENTER & CATALOG DESIGN TOKENS
 */

tailwind.config = {
    "darkMode": "class",
    "theme": {
        "extend": {
            "colors": {
                "outline-variant": "#ccc3d4",
                "inverse-on-surface": "#eef0ff",
                "on-primary": "#ffffff",
                "on-secondary": "#ffffff",
                "surface-tint": "#6f46b9",
                "surface-container-lowest": "#ffffff",
                "primary-fixed": "#ebdcff",
                "on-secondary-container": "#614283",
                "on-surface-variant": "#4a4452",
                "surface-container-highest": "#dae2fd",
                "on-tertiary-container": "#bfa37c",
                "error": "#ba1a1a",
                "tertiary": "#352407",
                "surface": "#faf8ff",
                "background": "#faf8ff",
                "surface-dim": "#d2d9f4",
                "on-tertiary-fixed": "#281801",
                "on-primary-container": "#b994ff",
                "outline": "#7b7483",
                "surface-container": "#eaedff",
                "tertiary-container": "#4d391b",
                "secondary-fixed-dim": "#dbb8ff",
                "error-container": "#ffdad6",
                "on-background": "#131b2e",
                "primary-fixed-dim": "#d3bbff",
                "on-error-container": "#93000a",
                "secondary-fixed": "#efdbff",
                "on-secondary-fixed": "#29074a",
                "inverse-surface": "#283044",
                "surface-variant": "#dae2fd",
                "on-secondary-fixed-variant": "#573878",
                "surface-container-high": "#e2e7ff",
                "primary-container": "#4c1d95",
                "on-tertiary": "#ffffff",
                "tertiary-fixed": "#fedeb3",
                "secondary-container": "#d9b5ff",
                "surface-container-low": "#f2f3ff",
                "surface-bright": "#faf8ff",
                "inverse-primary": "#d3bbff",
                "tertiary-fixed-dim": "#e0c299",
                "on-surface": "#131b2e",
                "secondary": "#6f5092",
                "on-tertiary-fixed-variant": "#584324",
                "on-primary-fixed": "#260059",
                "primary": "#340075",
                "on-primary-fixed-variant": "#572ba0",
                "on-error": "#ffffff"
            },
            "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            "spacing": {
                "margin-desktop": "1.5rem",
                "space-xl": "2rem",
                "gutter": "0.75rem",
                "space-sm": "0.375rem",
                "space-xs": "0.25rem",
                "space-md": "0.75rem",
                "space-lg": "1.25rem",
                "gutter-desktop": "1rem",
                "margin": "1rem"
            },
            "fontFamily": {
                "headline-xl": ["Inter"],
                "code-lg": ["JetBrains Mono"],
                "body-sm": ["Inter"],
                "body-md": ["Inter"],
                "label-md": ["JetBrains Mono"],
                "headline-sm": ["Inter"],
                "headline-lg": ["Inter"],
                "code-md": ["JetBrains Mono"],
                "code-sm": ["JetBrains Mono"],
                "label-sm": ["JetBrains Mono"],
                "headline-xl-mobile": ["Inter"],
                "headline-md": ["Inter"],
                "body-lg": ["Inter"]
            },
            "fontSize": {
                "headline-xl": ["32px", {
                    "lineHeight": "40px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "700"
                }],
                "code-lg": ["13px", {
                    "lineHeight": "18px",
                    "fontWeight": "500"
                }],
                "body-sm": ["12px", {
                    "lineHeight": "16px",
                    "fontWeight": "400"
                }],
                "body-md": ["13px", {
                    "lineHeight": "18px",
                    "fontWeight": "400"
                }],
                "label-md": ["11px", {
                    "lineHeight": "14px",
                    "letterSpacing": "0.04em",
                    "fontWeight": "600"
                }],
                "headline-sm": ["15px", {
                    "lineHeight": "20px",
                    "fontWeight": "600"
                }],
                "headline-lg": ["22px", {
                    "lineHeight": "28px",
                    "letterSpacing": "-0.015em",
                    "fontWeight": "600"
                }],
                "code-md": ["12px", {
                    "lineHeight": "16px",
                    "fontWeight": "400"
                }],
                "code-sm": ["11px", {
                    "lineHeight": "14px",
                    "fontWeight": "400"
                }],
                "label-sm": ["10px", {
                    "lineHeight": "12px",
                    "letterSpacing": "0.06em",
                    "fontWeight": "600"
                }],
                "headline-xl-mobile": ["24px", {
                    "lineHeight": "32px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "700"
                }],
                "headline-md": ["18px", {
                    "lineHeight": "24px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "600"
                }],
                "body-lg": ["14px", {
                    "lineHeight": "20px",
                    "fontWeight": "400"
                }]
            }
        }
    }
};
