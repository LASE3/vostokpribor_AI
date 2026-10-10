tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "inverse-on-surface": "#f6f0ea",
                "primary-fixed-dim": "#d3bbff",
                "on-surface": "#1e1b18",
                "outline": "#7b7483",
                "on-surface-variant": "#4a4452",
                "on-secondary": "#ffffff",
                "on-background": "#1e1b18",
                "on-primary-fixed-variant": "#572ba0",
                "surface-dim": "#dfd9d3",
                "background": "#fff8f2",
                "secondary-container": "#d9b5ff",
                "on-primary-container": "#b994ff",
                "primary-container": "#4c1d95",
                "secondary-fixed-dim": "#dbb8ff",
                "on-primary-fixed": "#260059",
                "surface-container-low": "#f9f2ec",
                "error": "#ba1a1a",
                "tertiary-fixed-dim": "#e0c299",
                "tertiary": "#352407",
                "surface-container-highest": "#e8e1dc",
                "surface-variant": "#e8e1dc",
                "inverse-surface": "#33302c",
                "on-tertiary-fixed-variant": "#584324",
                "on-secondary-fixed-variant": "#573878",
                "on-tertiary-fixed": "#281801",
                "inverse-primary": "#d3bbff",
                "on-secondary-container": "#614283",
                "on-tertiary-container": "#bfa37c",
                "on-tertiary": "#ffffff",
                "on-secondary-fixed": "#29074a",
                "surface-tint": "#6f46b9",
                "surface-container-high": "#eee7e1",
                "secondary-fixed": "#efdbff",
                "secondary": "#6f5092",
                "on-error": "#ffffff",
                "on-primary": "#ffffff",
                "tertiary-fixed": "#fedeb3",
                "primary-fixed": "#ebdcff",
                "on-error-container": "#93000a",
                "outline-variant": "#ccc3d4",
                "surface-container": "#f3ede7",
                "surface": "#fff8f2",
                "error-container": "#ffdad6",
                "surface-container-lowest": "#ffffff",
                "primary": "#340075",
                "tertiary-container": "#4d391b",
                "surface-bright": "#fff8f2"
            },
            borderRadius: {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            spacing: {
                "margin-mobile": "1rem",
                "margin": "1.5rem",
                "space-sm": "0.5rem",
                "space-xs": "0.25rem",
                "space-xl": "2rem",
                "space-lg": "1.5rem",
                "space-md": "1rem",
                "gutter-desktop": "1.5rem",
                "gutter-mobile": "0.75rem",
                "margin-desktop": "2.5rem",
                "gutter": "1rem"
            },
            fontFamily: {
                sans: ["Inter", "sans-serif"],
                mono: ["JetBrains Mono", "monospace"],
                "body-sm": ["Inter"],
                "body-md": ["Inter"],
                "headline-xl-mobile": ["Inter"],
                "headline-xl": ["Inter"],
                "label-lg": ["JetBrains Mono"],
                "headline-sm": ["Inter"],
                "headline-lg": ["Inter"],
                "label-sm": ["JetBrains Mono"],
                "headline-lg-mobile": ["Inter"],
                "headline-md": ["Inter"],
                "label-md": ["JetBrains Mono"],
                "body-lg": ["Inter"]
            },
            fontSize: {
                "body-sm": ["12px", {
                    "lineHeight": "16px",
                    "fontWeight": "400"
                }],
                "body-md": ["14px", {
                    "lineHeight": "20px",
                    "fontWeight": "400"
                }],
                "headline-xl-mobile": ["28px", {
                    "lineHeight": "34px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "700"
                }],
                "headline-xl": ["36px", {
                    "lineHeight": "44px",
                    "letterSpacing": "-0.025em",
                    "fontWeight": "700"
                }],
                "label-lg": ["13px", {
                    "lineHeight": "18px",
                    "letterSpacing": "0.02em",
                    "fontWeight": "500"
                }],
                "headline-sm": ["16px", {
                    "lineHeight": "24px",
                    "letterSpacing": "-0.005em",
                    "fontWeight": "600"
                }],
                "headline-lg": ["28px", {
                    "lineHeight": "36px",
                    "letterSpacing": "-0.02em",
                    "fontWeight": "600"
                }],
                "label-sm": ["10px", {
                    "lineHeight": "14px",
                    "letterSpacing": "0.04em",
                    "fontWeight": "600"
                }],
                "headline-lg-mobile": ["22px", {
                    "lineHeight": "28px",
                    "letterSpacing": "-0.015em",
                    "fontWeight": "600"
                }],
                "headline-md": ["20px", {
                    "lineHeight": "28px",
                    "letterSpacing": "-0.01em",
                    "fontWeight": "600"
                }],
                "label-md": ["11px", {
                    "lineHeight": "16px",
                    "letterSpacing": "0.03em",
                    "fontWeight": "500"
                }],
                "body-lg": ["16px", {
                    "lineHeight": "24px",
                    "fontWeight": "400"
                }]
            }
        }
    }
};
