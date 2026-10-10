/**
 * VOSTOKPRIBOR AI • SYS-AI-01: Tailwind Configuration
 */
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            "colors": {
                "surface-variant": "#e3dfff",
                "outline": "#7b7483",
                "surface-container": "#efebff",
                "on-secondary": "#ffffff",
                "tertiary": "#352407",
                "secondary-container": "#d9b5ff",
                "secondary": "#6f5092",
                "on-secondary-fixed-variant": "#573878",
                "surface-tint": "#6f46b9",
                "surface-dim": "#dad6ff",
                "on-tertiary-container": "#bfa37c",
                "inverse-primary": "#d3bbff",
                "on-primary-container": "#b994ff",
                "surface": "#fcf8ff",
                "surface-container-high": "#e9e5ff",
                "surface-container-low": "#f6f2ff",
                "inverse-surface": "#2d2a5b",
                "on-error": "#ffffff",
                "on-tertiary-fixed": "#281801",
                "secondary-fixed": "#efdbff",
                "on-primary": "#ffffff",
                "on-error-container": "#93000a",
                "outline-variant": "#ccc3d4",
                "error-container": "#ffdad6",
                "on-secondary-container": "#614283",
                "primary": "#340075",
                "on-surface": "#181445",
                "on-primary-fixed": "#260059",
                "on-tertiary-fixed-variant": "#584324",
                "on-primary-fixed-variant": "#572ba0",
                "tertiary-fixed": "#fedeb3",
                "error": "#ba1a1a",
                "on-background": "#181445",
                "surface-container-highest": "#e3dfff",
                "surface-container-lowest": "#ffffff",
                "primary-fixed": "#ebdcff",
                "on-tertiary": "#ffffff",
                "inverse-on-surface": "#f3eeff",
                "on-surface-variant": "#4a4452",
                "primary-container": "#4c1d95",
                "primary-fixed-dim": "#d3bbff",
                "tertiary-fixed-dim": "#e0c299",
                "surface-bright": "#fcf8ff",
                "secondary-fixed-dim": "#dbb8ff",
                "tertiary-container": "#4d391b",
                "background": "#fcf8ff",
                "on-secondary-fixed": "#29074a"
            },
            "borderRadius": {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            "spacing": {
                "margin": "1rem",
                "space-xl": "2rem",
                "space-xs": "0.25rem",
                "space-md": "0.75rem",
                "gutter-desktop": "1.5rem",
                "gutter": "1rem",
                "margin-desktop": "2rem",
                "space-lg": "1.25rem",
                "space-sm": "0.5rem"
            },
            "fontFamily": {
                "code-inline": ["JetBrains Mono"],
                "body-sm": ["Inter"],
                "headline-xl": ["Inter"],
                "headline-xl-mobile": ["Inter"],
                "label-sm": ["JetBrains Mono"],
                "headline-lg": ["Inter"],
                "body-md": ["Inter"],
                "label-md": ["JetBrains Mono"],
                "headline-md": ["Inter"],
                "body-lg": ["Inter"],
                "label-lg": ["JetBrains Mono"]
            },
            "fontSize": {
                "code-inline": ["12px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0em",
                    "fontWeight": "400"
                }],
                "body-sm": ["12px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0.005em",
                    "fontWeight": "400"
                }],
                "headline-xl": ["32px", {
                    "lineHeight": "40px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "700"
                }],
                "headline-xl-mobile": ["26px", {
                    "lineHeight": "32px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "700"
                }],
                "label-sm": ["10px", {
                    "lineHeight": "12px",
                    "letterSpacing": "0.04em",
                    "fontWeight": "500"
                }],
                "headline-lg": ["24px", {
                    "lineHeight": "32px",
                    "letterSpacing": "-0.015em",
                    "fontWeight": "600"
                }],
                "body-md": ["13px", {
                    "lineHeight": "18px",
                    "letterSpacing": "0em",
                    "fontWeight": "400"
                }],
                "label-md": ["11px", {
                    "lineHeight": "14px",
                    "letterSpacing": "0.03em",
                    "fontWeight": "500"
                }],
                "headline-md": ["18px", {
                    "lineHeight": "24px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "600"
                }],
                "body-lg": ["15px", {
                    "lineHeight": "22px",
                    "letterSpacing": "0em",
                    "fontWeight": "400"
                }],
                "label-lg": ["12px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0.02em",
                    "fontWeight": "600"
                }]
            }
        }
    }
};
