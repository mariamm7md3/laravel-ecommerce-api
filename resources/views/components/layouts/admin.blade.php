<x-layouts.basic title="Admin">
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <x-layouts.partials.sidebar />

            <!-- Layout container -->
            <div class="layout-page">
                <x-layouts.partials.navbar />

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
</x-layouts.basic>
