<x-layouts.admin title="home">

    {{-- View Sales + Statistics --}}
    <div class="row">
        <!-- View sales -->
        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-7">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0">Congratulations {{ $bestSeller->user->first_name ?? 'N/A' }} 🎉</h5>
                            <p class="mb-2">Best seller of the month</p>
                            <h4 class="text-primary mb-1">$ {{ number_format($bestSeller->total_spent ?? 0) }}</h4>
                            <a href="{{ route('orders.index', ['user_id' => $bestSeller->user_id ?? '']) }}" class="btn btn-primary">View Sales</a>
                        </div>
                    </div>
                    <div class="col-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('assets/img/illustrations/card-advance-sale.png') }}"
                                height="140"
                                alt="view sales" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View sales -->

        <!-- Statistics -->
        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">Statistics</h5>
                        <small class="text-muted">Updated 1 month ago</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $totalSales }}</h5>
                                    <small>Sales</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2">
                                    <i class="ti ti-users ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $totalCustomers }}</h5>
                                    <small>Customers</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $totalProducts }}</h5>
                                    <small>Products</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">{{ $totalRevenue }}</h5>
                                    <small>Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics -->
    </div>


    {{-- 4 Mini Cards + Earning Reports --}}
    <div class="row">
        {{-- 4 Stat Mini Cards --}}
        <div class="col-12 col-xl-4 mb-4">
            <div class="row g-4 h-100">
                {{-- Clients - Current Month --}}
                <div class="col-6">
                    <div class="card h-100 stat-mini-card stat-mini-card--current border-start border-4 border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="stat-mini-icon bg-label-primary">
                                    <i class="ti ti-users ti-md"></i>
                                </span>
                                <span class="badge bg-label-primary">Current Month</span>
                            </div>
                            <p class="text-muted mb-1">Clients</p>
                            <h3 class="mb-0 fw-bold">{{ $clientsCurrentMonth ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Clients - Last Month --}}
                <div class="col-6">
                    <div class="card h-100 stat-mini-card stat-mini-card--past border-start border-4 border-secondary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="stat-mini-icon bg-label-secondary">
                                    <i class="ti ti-users ti-md"></i>
                                </span>
                                <span class="badge bg-label-secondary">Last Month</span>
                            </div>
                            <p class="text-muted mb-1">Clients</p>
                            <h3 class="mb-0 fw-bold">{{ $clientsLastMonth ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Orders - Current Month --}}
                <div class="col-6">
                    <div class="card h-100 stat-mini-card stat-mini-card--current border-start border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="stat-mini-icon bg-label-info">
                                    <i class="ti ti-shopping-cart ti-md"></i>
                                </span>
                                <span class="badge bg-label-info">Current Month</span>
                            </div>
                            <p class="text-muted mb-1">Orders</p>
                            <h3 class="mb-0 fw-bold">{{ $ordersCurrentMonth ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                {{-- Orders - Last Month --}}
                <div class="col-6">
                    <div class="card h-100 stat-mini-card stat-mini-card--past border-start border-4 border-secondary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="stat-mini-icon bg-label-secondary">
                                    <i class="ti ti-shopping-cart ti-md"></i>
                                </span>
                                <span class="badge bg-label-secondary">Last Month</span>
                            </div>
                            <p class="text-muted mb-1">Orders</p>
                            <h3 class="mb-0 fw-bold">{{ $ordersLastMonth ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earning Reports Tabs-->
        <div class="col-12 col-xl-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Earning Reports</h5>
                        <small class="text-muted">Yearly Earnings Overview</small>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn btn-outline-primary btn-sm dropdown-toggle d-flex align-items-center gap-1"
                            type="button"
                            id="earningReportsYearId"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ti ti-calendar ti-sm"></i>
                            {{ $selectedYear }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsYearId">
                            @foreach($availableYears as $year)
                                <li class="dropdown-item {{ $selectedYear == $year ? 'active' : '' }}">
                                    <a href="{{ request()->fullUrlWithQuery(['year' => $year]) }}">
                                        {{ $year }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card-body">

                    {{-- Summary Row --}}
                    <div class="row g-3 mb-4">
                        <div class="col-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded earning-summary-item bg-label-primary">
                                <span class="earning-summary-icon bg-primary text-white">
                                    <i class="ti ti-shopping-cart ti-md"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Total Orders</small>
                                    <h5 class="mb-0 fw-bold">{{ $totalOrders ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded earning-summary-item bg-label-info">
                                <span class="earning-summary-icon bg-info text-white">
                                    <i class="ti ti-users ti-md"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Total Clients</small>
                                    <h5 class="mb-0 fw-bold">{{ $totalClients ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="d-flex align-items-center gap-2 p-3 rounded earning-summary-item bg-label-warning">
                                <span class="earning-summary-icon bg-warning text-white">
                                    <i class="ti ti-currency-dollar ti-md"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Total Profit</small>
                                    <h5 class="mb-0 fw-bold">{{ $totalProfit ?? 0 }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs widget-nav-tabs pb-3 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
                        <li class="nav-item">
                            <a
                                href="javascript:void(0);"
                                class="nav-link btn active d-flex flex-column align-items-center justify-content-center"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-orders-id"
                                aria-controls="navs-orders-id"
                                aria-selected="true">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">Orders</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="javascript:void(0);"
                                class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-sales-id"
                                aria-controls="navs-sales-id"
                                aria-selected="false">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-chart-bar ti-sm"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">Sales</h6>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="javascript:void(0);"
                                class="nav-link btn d-flex flex-column align-items-center justify-content-center"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-profit-id"
                                aria-controls="navs-profit-id"
                                aria-selected="false">
                                <div class="badge bg-label-secondary rounded p-2">
                                    <i class="ti ti-currency-dollar ti-sm"></i>
                                </div>
                                <h6 class="tab-widget-title mb-0 mt-2">Profit</h6>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-0 ms-0 ms-sm-2">
                        <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                            <div id="earningReportsTabsOrders"></div>
                        </div>
                        <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
                            <div id="earningReportsTabsSales"></div>
                        </div>
                        <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
                            <div id="earningReportsTabsProfit"></div>
                        </div>
                        <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
                            <div id="earningReportsTabsIncome"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Monthly Report + (Clients/Orders Count) --}}
    <div class="row">

        {{-- Clients/Orders Count Comparison --}}
        <div class="col-12 col-xl-4 mb-4">
            <div class="d-flex flex-column gap-4 h-100">

                {{-- Clients Count Comparison --}}
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Clients Count</h6>
                        <div class="dropdown">
                            <button
                                class="btn btn-sm btn-outline-primary dropdown-toggle d-flex align-items-center gap-1"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="ti ti-calendar ti-xs"></i>
                                {{ $compareYearA }} / {{ $compareYearB }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 220px">
                                <form method="GET">
                                    <input type="hidden" name="year" value="{{ $selectedYear }}">
                                    <input type="hidden" name="report_year" value="{{ $selectedReportYear }}">
                                    <input type="hidden" name="report_month" value="{{ $selectedReportMonth }}">
                                    <input type="hidden" name="branch_id" value="{{ $selectedBranchId }}">

                                    <label class="form-label small text-muted">Year A</label>
                                    <select name="compare_year_a" class="form-select form-select-sm mb-2" onchange="this.form.submit()">
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ $compareYearA == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>

                                    <label class="form-label small text-muted">Year B</label>
                                    <select name="compare_year_b" class="form-select form-select-sm" onchange="this.form.submit()">
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ $compareYearB == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between compare-row">
                            <div class="text-center compare-side">
                                <span class="compare-icon bg-label-primary">
                                    <i class="ti ti-users ti-sm"></i>
                                </span>
                                <h4 class="mb-0 mt-2">{{ $clientsCompareA }}</h4>
                                <small class="text-muted">{{ $compareYearA }}</small>
                            </div>
                            <span class="compare-vs">VS</span>
                            <div class="text-center compare-side">
                                <span class="compare-icon bg-label-secondary">
                                    <i class="ti ti-users ti-sm"></i>
                                </span>
                                <h4 class="mb-0 mt-2">{{ $clientsCompareB }}</h4>
                                <small class="text-muted">{{ $compareYearB }}</small>
                            </div>
                        </div>

                        @php
                            $clientsTotal = ($clientsCompareA + $clientsCompareB) ?: 1;
                            $clientsPctA  = round($clientsCompareA / $clientsTotal * 100);
                        @endphp
                        <div class="compare-bar mt-3">
                            <div class="compare-bar-fill" style="width: {{ $clientsPctA }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Orders Count Comparison --}}
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Orders Count</h6>
                        <span class="badge bg-label-info">{{ $compareYearA }} / {{ $compareYearB }}</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between compare-row">
                            <div class="text-center compare-side">
                                <span class="compare-icon bg-label-info">
                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                </span>
                                <h4 class="mb-0 mt-2">{{ $ordersCompareA }}</h4>
                                <small class="text-muted">{{ $compareYearA }}</small>
                            </div>
                            <span class="compare-vs">VS</span>
                            <div class="text-center compare-side">
                                <span class="compare-icon bg-label-secondary">
                                    <i class="ti ti-shopping-cart ti-sm"></i>
                                </span>
                                <h4 class="mb-0 mt-2">{{ $ordersCompareB }}</h4>
                                <small class="text-muted">{{ $compareYearB }}</small>
                            </div>
                        </div>

                        @php
                            $ordersTotal = ($ordersCompareA + $ordersCompareB) ?: 1;
                            $ordersPctA  = round($ordersCompareA / $ordersTotal * 100);
                        @endphp
                        <div class="compare-bar mt-3">
                            <div class="compare-bar-fill compare-bar-fill--info" style="width: {{ $ordersPctA }}%"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Monthly Report -->
        <div class="col-12 col-xl-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between flex-wrap gap-3">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Monthly Reports</h5>
                        <small class="text-muted">Monthly Earnings Overview</small>
                    </div>

                    {{-- Filters --}}
                    <form method="GET" class="d-flex gap-2 flex-wrap" id="monthlyReportFilters">
                        <input type="hidden" name="year" value="{{ $selectedYear }}">
                        <input type="hidden" name="compare_year_a" value="{{ $compareYearA }}">
                        <input type="hidden" name="compare_year_b" value="{{ $compareYearB }}">

                        <select name="report_year" class="form-select form-select-sm w-auto" onchange="document.getElementById('monthlyReportFilters').submit()">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $selectedReportYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>

                        <select name="report_month" class="form-select form-select-sm w-auto" onchange="document.getElementById('monthlyReportFilters').submit()">
                            @foreach($monthNames as $num => $name)
                                <option value="{{ $num }}" {{ $selectedReportMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>

                        <select name="branch_id" class="form-select form-select-sm w-auto" onchange="document.getElementById('monthlyReportFilters').submit()">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ (string) $selectedBranchId === (string) $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name[app()->getLocale()] }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="card-body">
                    {{-- Summary Row --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 p-3 rounded earning-summary-item bg-label-primary">
                                <span class="earning-summary-icon bg-primary text-white">
                                    <i class="ti ti-shopping-cart ti-md"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Total Orders</small>
                                    <h5 class="mb-0 fw-bold">{{ $monthlyReportTotalOrders }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 p-3 rounded earning-summary-item bg-label-success">
                                <span class="earning-summary-icon bg-success text-white">
                                    <i class="ti ti-currency-dollar ti-md"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Total Sales</small>
                                    <h5 class="mb-0 fw-bold">{{ number_format($monthlyReportTotalSales, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="monthlyReportChart"></div>
                </div>
            </div>
        </div>
        <!-- / Monthly Report -->

    </div>

    {{-- Popular Products --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('home.popular_products') }}</h5>
                    <span class="badge bg-label-secondary">{{ __('home.last_30_days') }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table paginated-table" id="popularProductsTable">
                        <thead class="border-top">
                        <tr>
                            <th>{{ __('products.product') }}</th>
                            <th>{{ __('products.industry') }}</th>
                            <th>{{ __('products.category') }}</th>
                            <th>{{ __('products.price') }}</th>
                            <th>{{ __('products.stock') }}</th>
                            <th>{{ __('products.rate') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($popularProducts as $index => $product)
                            <tr class="paginated-row" data-page="{{ intdiv($index, 5) + 1 }}"
                                style="{{ $index >= 5 ? 'display:none;' : '' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($product->photo)
                                            <img src="{{ $product->photo_url }}" alt=""
                                                 class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                                 style="width: 40px; height: 40px; font-size: 16px;">
                                                {{ strtoupper(substr($product->name['en'], 0, 1)) }}
                                            </div>
                                        @endif
                                        <h6 class="mb-0">{{ $product->name[app()->getLocale()] }}</h6>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ $product->industry->name[app()->getLocale()] }}
                                    </span>
                                </td>

                                <td>
                                    @foreach($product->categories as $category)
                                        <span class="badge bg-label-info me-1 mb-1">{{ $category->name[app()->getLocale()] }}</span>
                                    @endforeach
                                </td>

                                <td>{{ $product->min_price ? number_format($product->min_price, 2) : '-' }}</td>

                                <td>
                                    @if($product->total_stock > 0)
                                        <span class="badge bg-label-success">{{ __('products.in_stock') }} ({{ $product->total_stock }})</span>
                                    @else
                                        <span class="badge bg-label-danger">{{ __('products.out_of_stock') }}</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="fw-semibold d-flex align-items-center">
                                        {{ $product->rate }}
                                        <i class="ti ti-star-filled text-warning ms-1"></i>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    {{ __('products.no_products_found') }}
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($popularProducts->count() > 5)
                    <div class="card-footer d-flex justify-content-center">
                        <nav>
                            <ul class="pagination pagination-sm mb-0 paginated-nav" id="popularProductsPagination">
                                <li class="page-item" data-action="prev">
                                    <a class="page-link" href="#"><i class="ti ti-chevron-left"></i></a>
                                </li>
                                <li class="page-item active" data-page-link="1">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item" data-page-link="2">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item" data-action="next">
                                    <a class="page-link" href="#"><i class="ti ti-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Top Orders --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('home.top_orders') }}</h5>
                    <span class="badge bg-label-secondary">{{ __('home.last_30_days') }}</span>
                </div>

                <div class="table-responsive">
                    <table class="table paginated-table" id="topOrdersTable">
                        <thead class="border-top">
                        <tr>
                            <th>#</th>
                            <th>{{ __('orders.customer') }}</th>
                            <th>{{ __('orders.branch') }}</th>
                            <th class="text-center">{{ __('orders.items_count') }}</th>
                            <th class="text-center">{{ __('orders.status_column') }}</th>
                            <th>{{ __('orders.total') }}</th>
                            <th class="text-center">{{ __('orders.date') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($topOrders as $index => $order)
                            <tr class="paginated-row" data-page="{{ intdiv($index, 5) + 1 }}"
                                style="{{ $index >= 5 ? 'display:none;' : '' }}">

                                <td class="fw-medium text-muted">#{{ $order->id }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($order->user->photo)
                                            <img src="{{ $order->user->photo_url }}" alt=""
                                                 class="rounded-2 me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-2 me-2 d-flex align-items-center justify-content-center bg-label-primary fw-bold"
                                                 style="width: 40px; height: 40px; font-size: 16px;">
                                                {{ strtoupper(substr($order->user->first_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <h6 class="mb-0">{{ $order->user->first_name }} {{ $order->user->last_name }}</h6>
                                    </div>
                                </td>

                                <td>
                                    @if($order->branch)
                                        <span class="badge bg-label-secondary">{{ $order->branch->name[app()->getLocale()] }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <span class="badge bg-label-dark">{{ $order->items_count }}</span>
                                </td>

                                <td class="text-center">
                                    @php
                                        $statusColor = match($order->status->value ?? $order->status) {
                                            'pending'    => 'warning',
                                            'processing' => 'info',
                                            'delivered'  => 'success',
                                            'cancelled'  => 'danger',
                                            'refunded'   => 'secondary',
                                            default      => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-label-{{ $statusColor }}">
                                        {{ $order->status->label() ?? $order->status }}
                                    </span>
                                </td>

                                <td class="fw-medium">
                                    <span class="badge bg-label-success">
                                        {{ number_format($order->total, 2) }}
                                    </span>
                                </td>

                                <td class="text-center text-muted">
                                    <span class="d-block">{{ $order->date->format('M d, Y') }}</span>
                                    <small class="text-muted">{{ $order->date->format('h:i A') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">{{ __('orders.no_orders_found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if($topOrders->count() > 5)
                    <div class="card-footer d-flex justify-content-center">
                        <nav>
                            <ul class="pagination pagination-sm mb-0 paginated-nav" id="topOrdersPagination">
                                <li class="page-item" data-action="prev">
                                    <a class="page-link" href="#"><i class="ti ti-chevron-left"></i></a>
                                </li>
                                <li class="page-item active" data-page-link="1">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item" data-page-link="2">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item" data-action="next">
                                    <a class="page-link" href="#"><i class="ti ti-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <script>
        window.earningReportsChart = {
            orders: @json($ordersMonthly),
            sales: @json($salesMonthly),
            profit: @json($profitMonthly),
            months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        };

        window.monthlyReportChart = {
            orders: @json($dailyOrders),
            sales: @json($dailySales),
            days: @json(range(1, $daysInMonth)),
        };
    </script>

    <script src="{{ asset('assets/js/home-earning-reports.js') }}"></script>
    <script src="{{ asset('assets/js/monthly-report.js') }}"></script>

    <script src="{{ asset('assets/js/paginated-tables.js') }}"></script>
</x-layouts.admin>
