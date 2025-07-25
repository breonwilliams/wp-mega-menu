(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', initBlissMegaMenu);

    function initBlissMegaMenu() {
        // Find all mega menu instances
        const megaMenus = document.querySelectorAll('.bliss-mega-menu');
        
        megaMenus.forEach(function(menuWrapper) {
            const menuId = 'bliss-menu-' + Math.random().toString(36).substr(2, 9);
            const menu = menuWrapper.querySelector('.wp-nav-menu');
            const toggleBtn = menuWrapper.querySelector('.mobile-menu-toggle');
            
            // Set unique ID
            if (menu && !menu.id) {
                menu.id = menuId;
            }
            
            // Mobile menu toggle
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    menu.classList.toggle('mobile-open');
                });
            }
            
            // Mobile submenu toggles
            const submenuToggles = menuWrapper.querySelectorAll('.mobile-submenu-toggle');
            submenuToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Only handle on mobile
                    if (window.innerWidth <= 768) {
                        const menuItem = toggle.closest('.menu-item');
                        menuItem.classList.toggle('mobile-open');
                    }
                });
            });
            
            // Handle clicks on menu links with # href on mobile
            const hashLinks = menuWrapper.querySelectorAll('.menu-header > a[href="#"]');
            hashLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        const menuItem = link.closest('.menu-item');
                        menuItem.classList.toggle('mobile-open');
                    }
                });
            });
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const megaMenus = document.querySelectorAll('.bliss-mega-menu');
            
            megaMenus.forEach(function(menuWrapper) {
                if (!menuWrapper.contains(event.target)) {
                    const menu = menuWrapper.querySelector('.wp-nav-menu');
                    const openItems = menuWrapper.querySelectorAll('.menu-item.mobile-open');
                    
                    if (menu) {
                        menu.classList.remove('mobile-open');
                    }
                    
                    openItems.forEach(function(item) {
                        item.classList.remove('mobile-open');
                    });
                }
            });
        });
        
        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth > 768) {
                    const megaMenus = document.querySelectorAll('.bliss-mega-menu');
                    
                    megaMenus.forEach(function(menuWrapper) {
                        const menu = menuWrapper.querySelector('.wp-nav-menu');
                        const openItems = menuWrapper.querySelectorAll('.menu-item.mobile-open');
                        
                        if (menu) {
                            menu.classList.remove('mobile-open');
                        }
                        
                        openItems.forEach(function(item) {
                            item.classList.remove('mobile-open');
                        });
                    });
                }
            }, 250);
        });
        
        // Desktop mega menu positioning handled by CSS
    }
})();