@php
    // Expected variables:
    // - $toggleId (string)
    // - $hamburgerBtnId (string) (button that opens drawer)
    // - $panelId (string) (drawer panel id)
    //
    // Optional:
    // - $lockClass (string) default 'overflow-hidden'
@endphp

<script>
    (function () {
        const toggle = document.getElementById(@json($toggleId));
        const hamburger = document.getElementById(@json($hamburgerBtnId));
        const panel = document.getElementById(@json($panelId));

        if (!toggle || !panel) return;

        const overlay = panel.previousElementSibling;

        const lockClass = @json($lockClass ?? 'overflow-hidden');

        const lockScroll = () => document.body.classList.add(lockClass);
        const unlockScroll = () => document.body.classList.remove(lockClass);

        window.__uhDrawerLastFocused = window.__uhDrawerLastFocused || {};
        const key = @json($toggleId);

        const setAriaExpanded = (isOpen) => {
            if (hamburger) hamburger.setAttribute('aria-expanded', String(isOpen));
        };

        const getIsOpen = () => !!toggle.checked;

        const open = () => {
            if (getIsOpen()) return;
            window.__uhDrawerLastFocused[key] = document.activeElement;
            toggle.checked = true;
            toggle.dispatchEvent(new Event('change', { bubbles: true }));
        };

        const close = () => {
            if (!getIsOpen()) return;
            toggle.checked = false;
            toggle.dispatchEvent(new Event('change', { bubbles: true }));
        };

        const applyState = () => {
            const isOpen = getIsOpen();

            panel.classList.toggle('-translate-x-full', !isOpen);
            panel.classList.toggle('translate-x-0', isOpen);

            if (overlay) {
                overlay.classList.toggle('hidden', !isOpen);
            }

            if (isOpen) {
                lockScroll();
                setAriaExpanded(true);
            } else {
                unlockScroll();
                setAriaExpanded(false);

                const last = window.__uhDrawerLastFocused[key];
                const restored = last && typeof last.focus === 'function' && document.contains(last);
                if (restored) {
                    last.focus();
                } else if (hamburger && document.contains(hamburger)) {
                    hamburger.focus();
                }
            }
        };

        applyState();

        toggle.addEventListener('change', applyState, { passive: true });

        if (hamburger) {
            hamburger.addEventListener('click', function () {
                getIsOpen() ? close() : open();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', close);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            if (!toggle.checked) return;
            close();
        });

        window.__uhDrawerOpen = window.__uhDrawerOpen || {};
        window.__uhDrawerClose = window.__uhDrawerClose || {};
        window.__uhDrawerOpen[key] = open;
        window.__uhDrawerClose[key] = close;
    })();
</script>