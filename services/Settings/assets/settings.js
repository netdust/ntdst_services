window.ntdst = window.ntdst || {};

((exports) => {
    "use strict";

    exports.settings = {
        start() {
            this.setupView();
        },

        setupView() {
            const headers = document.querySelectorAll(".setting-group-header");

            headers.forEach(header => {
                const parent = header.closest(".setting-group");

                if (parent) {
                    const headerHeight = header.offsetHeight; // Get header height

                    // Set initial styles
                    parent.style.overflow = "hidden";
                    parent.style.transition = "height 0.3s ease-in-out";
                    parent.style.height = `${parent.scrollHeight}px`; // Fully expanded by default

                    header.addEventListener("click", () => {
                        if (parent.classList.contains("collapsed")) {
                            // Expand
                            parent.style.height = `${parent.scrollHeight}px`;
                        } else {
                            // Collapse to header height
                            parent.style.height = `${headerHeight}px`;
                        }

                        parent.classList.toggle("collapsed");
                    });

                    // Ensure correct height on page resize
                    window.addEventListener("resize", () => {
                        if (!parent.classList.contains("collapsed")) {
                            parent.style.height = `${parent.scrollHeight}px`;
                        }
                    });
                }
            });
        }

    };

    document.addEventListener("DOMContentLoaded", () => {
        exports.settings.start();
    });

})(window.ntdst);
