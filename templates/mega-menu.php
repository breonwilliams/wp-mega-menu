<?php
// Get template arguments
$menu_args = $template_args ?? array();
$menu_id = $menu_args['menu'] ?? '';
$theme_location = $menu_args['theme_location'] ?? '';
$fallback = $menu_args['fallback'] ?? 'static';

// Check if we should use dynamic menu
$use_dynamic = false;
$nav_menu_args = array();

// Determine which menu to use
if (!empty($menu_id)) {
    // Menu specified by ID, slug, or name
    $nav_menu_args['menu'] = $menu_id;
    $use_dynamic = true;
} elseif (!empty($theme_location)) {
    // Menu specified by theme location
    $nav_menu_args['theme_location'] = $theme_location;
    $use_dynamic = true;
} else {
    // Try to find a menu automatically
    $menus = wp_get_nav_menus();
    if (!empty($menus)) {
        $nav_menu_args['menu'] = $menus[0]->term_id;
        $use_dynamic = true;
    }
}

// If we have a dynamic menu, check if it exists
if ($use_dynamic && !empty($nav_menu_args)) {
    $menu_exists = false;
    
    if (isset($nav_menu_args['menu'])) {
        $menu_obj = wp_get_nav_menu_object($nav_menu_args['menu']);
        $menu_exists = ($menu_obj !== false);
    } elseif (isset($nav_menu_args['theme_location'])) {
        $locations = get_nav_menu_locations();
        $menu_exists = isset($locations[$nav_menu_args['theme_location']]);
    }
    
    $use_dynamic = $menu_exists;
}
?>

<div class="bliss-mega-menu">
    <nav class="navbar">
        <div class="nav-container">
            <?php if ($use_dynamic): ?>
                <?php
                // Use dynamic WordPress menu
                wp_nav_menu(array_merge($nav_menu_args, array(
                    'container' => false,
                    'menu_class' => 'wp-nav-menu',
                    'menu_id' => 'bliss-main-menu',
                    'walker' => new Bliss_Mega_Menu_Walker(),
                    'fallback_cb' => false,
                    'depth' => 4 // Support 4 levels for mega menu
                )));
                ?>
            <?php elseif ($fallback === 'static'): ?>
                <!-- Static fallback menu -->
                <ul class="wp-nav-menu" id="bliss-main-menu">
                <li class="menu-item">
                    <a href="/">Home</a>
                </li>
                
                <li class="menu-item">
                    <a href="/about">About</a>
                </li>
                
                <!-- Plumbing Services Mega Menu -->
                <li class="menu-item menu-item-has-children">
                    <div class="menu-header">
                        <a href="#" class="menu-link">Plumbing Services</a>
                        <button class="mobile-submenu-toggle"></button>
                    </div>
                    <ul class="sub-menu mega-menu">
                        <div class="mega-content">
                            <!-- Column 1: Residential Plumbing -->
                            <div class="mega-column">
                                <a href="/residential-plumbing/" class="section-header">Residential Plumbing</a>
                                
                                <div class="service-group">
                                    <a href="/residential-plumbing/repairs/" class="service-group-link">Plumbing Repairs & Maintenance</a>
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/residential-plumbing/repairs/toilet-repair/">Toilet Repair & Unclog</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/sink-repair/">Sink Repairs & Install</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/drains/">Laundry & Floor Drains</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/wash-machine/">Wash Machine Hose Repair</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/garbage-disposal/">Garbage Disposal Repairs</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/tub-shower/">Tub & Shower Repair</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/faucet-repair-installation/">Faucet Repair & Installation</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/repairs/custom-fixtures/">Custom Fixtures</a></li>
                                    </ul>
                                </div>

                                <div class="service-group">
                                    <a href="/residential-plumbing/leak-repairs/" class="service-group-link">Leak Repairs</a>
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/residential-plumbing/leak-repairs/gas-pipe-leak/">Gas Pipe Leak Repair</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/leak-repairs/leak-detection/">Leak Detection & Repairs</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/leak-repairs/slab-leak/">Slab Leak Detection</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/leak-repairs/video-leak-detection/">Video Camera Detection</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/leak-repairs/wall-leak/">Wall Leak Detection</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Column 2: Pipes & Sewer -->
                            <div class="mega-column">
                                <a href="/residential-plumbing/pipe-replacement/" class="section-header">Pipes & Sewer</a>
                                
                                <div class="service-group">
                                    <a href="/residential-plumbing/pipe-replacement/" class="service-group-link">Pipe Replacement</a>
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/residential-plumbing/pipe-replacement/polybutylene/">Polybutylene Pipe</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/pipe-replacement/galvanized/">Galvanized Pipe</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/pipe-replacement/defective/">Defective Pipe</a></li>
                                    </ul>
                                </div>

                                <div class="service-group">
                                    <a href="/residential-plumbing/sewer-services/" class="service-group-link">Sewer Services</a>
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/residential-plumbing/sewer-services/cleaning/">Sewer & Drain Cleaning</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/sewer-services/line-installation/">Sewer Line Installation</a></li>
                                        <li class="service-child"><a href="/residential-plumbing/sewer-services/repair-jetting/">Sewer Line Repair & Jetting</a></li>
                                    </ul>
                                </div>

                                <div class="service-group">
                                    <a href="/residential-plumbing/whole-house-filtration/" class="service-group-link">Whole House Filtration</a>
                                </div>
                            </div>

                            <!-- Column 3: Commercial & Construction -->
                            <div class="mega-column">
                                <a href="/commercial-plumbing/" class="section-header">Commercial Plumbing</a>
                                
                                <div class="service-group">
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/commercial-plumbing/backflow-testing/">Backflow Preventer Testing</a></li>
                                        <li class="service-child"><a href="/commercial-plumbing/backflow-repair/">Backflow Repair & Replacement</a></li>
                                        <li class="service-child"><a href="/commercial-plumbing/lift-station-repair/">Lift Station Repair</a></li>
                                        <li class="service-child"><a href="/commercial-plumbing/video-leak-detection/">Video Leak Inspection</a></li>
                                        <li class="service-child"><a href="/commercial-plumbing/water-heaters/">Commercial Water Heaters</a></li>
                                    </ul>
                                </div>

                                <a href="/new-construction-plumbing/" class="section-header" style="margin-top: 30px;">New Construction</a>
                                <div class="service-group">
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/new-construction-plumbing/">New Construction Plumbing</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Column 4: Water Heaters -->
                            <div class="mega-column">
                                <a href="/water-heaters/" class="section-header">Water Heaters</a>
                                
                                <div class="service-group">
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/water-heaters/installation/">Water Heater Installation</a></li>
                                        <li class="service-child"><a href="/water-heaters/repair/">Water Heater Repair</a></li>
                                        <li class="service-child"><a href="/water-heaters/gas-water-heaters/">Gas Water Heaters</a></li>
                                        <li class="service-child"><a href="/water-heaters/solar/">Solar Water Heating</a></li>
                                    </ul>
                                </div>

                                <div class="service-group">
                                    <a href="/water-heaters/tankless/" class="service-group-link">Tankless Water Heaters</a>
                                    <ul class="service-children">
                                        <li class="service-child"><a href="/water-heaters/tankless/maintenance/">Tankless Maintenance</a></li>
                                        <li class="service-child"><a href="/water-heaters/tankless/ultra/">Tankless Ultra</a></li>
                                        <li class="service-child"><a href="/water-heaters/tankless/energy-efficient/">Energy Efficient</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>

                <!-- Service Areas Mega Menu -->
                <li class="menu-item menu-item-has-children">
                    <div class="menu-header">
                        <a href="/service-areas/" class="menu-link">Service Areas</a>
                        <button class="mobile-submenu-toggle"></button>
                    </div>
                    <ul class="sub-menu mega-menu">
                        <div class="areas-mega-content">
                            <!-- Column 1: Mecklenburg County -->
                            <div class="mega-column">
                                <div class="county-section">
                                    <a href="/service-areas/mecklenburg-county/" class="county-header">Mecklenburg County</a>
                                    <ul class="city-list">
                                        <li class="city-item"><a href="/service-areas/mecklenburg-county/davidson/">Davidson</a></li>
                                        <li class="city-item"><a href="/service-areas/mecklenburg-county/huntersville/">Huntersville</a></li>
                                        <li class="city-item"><a href="/service-areas/mecklenburg-county/matthews/">Matthews</a></li>
                                        <li class="city-item"><a href="/service-areas/mecklenburg-county/mint-hill/">Mint Hill</a></li>
                                        <li class="city-item"><a href="/service-areas/mecklenburg-county/pineville/">Pineville</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Column 2: Cabarrus County -->
                            <div class="mega-column">
                                <div class="county-section">
                                    <a href="/service-areas/cabarrus-county/" class="county-header">Cabarrus County</a>
                                    <ul class="city-list">
                                        <li class="city-item"><a href="/service-areas/cabarrus-county/concord/">Concord</a></li>
                                        <li class="city-item"><a href="/service-areas/cabarrus-county/harrisburg/">Harrisburg</a></li>
                                        <li class="city-item"><a href="/service-areas/cabarrus-county/kannapolis/">Kannapolis</a></li>
                                        <li class="city-item"><a href="/service-areas/cabarrus-county/midland/">Midland</a></li>
                                        <li class="city-item"><a href="/service-areas/cabarrus-county/mount-pleasant/">Mount Pleasant</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Column 3: Gaston County -->
                            <div class="mega-column">
                                <div class="county-section">
                                    <a href="/service-areas/gaston-county/" class="county-header">Gaston County</a>
                                    <ul class="city-list">
                                        <li class="city-item"><a href="/service-areas/gaston-county/belmont/">Belmont</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/bessemer-city/">Bessemer City</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/cramerton/">Cramerton</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/dallas/">Dallas</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/gastonia/">Gastonia</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/high-shoals/">High Shoals</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/lowell/">Lowell</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/mcadenville/">McAdenville</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/mount-holly/">Mount Holly</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/ranlo/">Ranlo</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/spencer-mountain/">Spencer Mountain</a></li>
                                        <li class="city-item"><a href="/service-areas/gaston-county/stanley/">Stanley</a></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Column 4: Other Areas -->
                            <div class="mega-column">
                                <div class="county-section">
                                    <a href="/service-areas/iredell-county/" class="county-header">Iredell County</a>
                                    <ul class="city-list">
                                        <li class="city-item"><a href="/service-areas/iredell-county/mooresville/">Mooresville</a></li>
                                        <li class="city-item"><a href="/service-areas/iredell-county/statesville/">Statesville</a></li>
                                        <li class="city-item"><a href="/service-areas/iredell-county/troutman/">Troutman</a></li>
                                        <li class="city-item"><a href="/service-areas/iredell-county/harmony/">Harmony</a></li>
                                        <li class="city-item"><a href="/service-areas/iredell-county/love-valley/">Love Valley</a></li>
                                    </ul>
                                </div>

                                <div class="service-group" style="margin-top: 25px;">
                                    <ul class="city-list">
                                        <li class="city-item"><a href="/service-areas/union-county/">Union County</a></li>
                                        <li class="city-item"><a href="/service-areas/lincoln-county/">Lincoln County</a></li>
                                        <li class="city-item"><a href="/service-areas/rowan-county/">Rowan County</a></li>
                                        <li class="city-item"><a href="/service-areas/catawba-county/">Catawba County</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>

                <li class="menu-item">
                    <a href="/careers/">Careers</a>
                </li>

                <li class="menu-item">
                    <a href="/contact-us/">Contact</a>
                </li>
            </ul>
            <?php endif; ?>
            
            <!-- Mobile menu toggle -->
            <button class="mobile-menu-toggle">☰</button>
        </div>
    </nav>
</div>