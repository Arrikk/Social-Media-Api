
<div class="nk-block">
    <div class="card card-bordered card-stretch">
        <div class="card-inner-group">
            <div class="card-inner position-relative card-tools-toggle">
                <div class="card-title-group">
                    <div class="card-tools">
                        <div class="form-inline flex-nowrap gx-3">
                            <div class="form-wrap w-150px">
                                <select class="form-select js-select2" data-search="off" data-placeholder="Bulk Action">
                                    <option value="">Bulk Action</option>
                                    <option value="email">Send Email</option>
                                    <option value="group">Change Group</option>
                                    <option value="suspend">Suspend User</option>
                                    <option value="delete">Delete User</option>
                                </select>
                            </div>
                            <div class="btn-wrap">
                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                                <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                            </div>
                        </div><!-- .form-inline -->
                    </div><!-- .card-tools -->
                    <div class="card-tools me-n1">
                        <ul class="btn-toolbar gx-1">
                            <li>
                                <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                            </li><!-- li -->
                            <li class="btn-toolbar-sep"></li><!-- li -->
                            <li>
                                <div class="toggle-wrap">
                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                    <div class="toggle-content" data-content="cardTools">
                                        <ul class="btn-toolbar gx-1">
                                            <li class="toggle-close">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                            </li><!-- li -->
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-setting"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                        <ul class="link-check" id="limit-list">
                                                            <li><span>Show</span></li>
                                                            <li class="active"><a href="javascript:;">10</a></li>
                                                            <li><a href="javascript:;">20</a></li>
                                                            <li><a href="javascript:;">50</a></li>
                                                        </ul>
                                                        <ul class="link-check" id="order-list">
                                                            <li class="order-title"><span>Order</span></li>
                                                            <li class="active"><a href="javascript:;">DESC</a></li>
                                                            <li><a href="javascript:;">ASC</a></li>
                                                        </ul>
                                                    </div>
                                                </div><!-- .dropdown -->
                                            </li><!-- li -->
                                        </ul><!-- .btn-toolbar -->
                                    </div><!-- .toggle-content -->
                                </div><!-- .toggle-wrap -->
                            </li><!-- li -->
                        </ul><!-- .btn-toolbar -->
                    </div><!-- .card-tools -->
                </div><!-- .card-title-group -->
                <div class="card-search search-wrap" data-search="search">
                    <div class="card-body">
                        <div class="search-content">
                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                            <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by user or email">
                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                        </div>
                    </div>
                </div><!-- .card-search -->
            </div><!-- .card-inner -->
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">User</span></div>
                        <div class="nk-tb-col tb-col-mb"><span class="sub-text">Amount</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Request Date</span></div>
                        <div class="nk-tb-col tb-col-xl"><span class="sub-text">issued Date</span></div>
                        <div class="nk-tb-col tb-col-xl"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Action</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                    <ul class="link-tidy sm no-bdr">
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="bl">
                                                <label class="custom-control-label" for="bl">Amount</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked="" id="ph">
                                                <label class="custom-control-label" for="ph">Request Date</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="vri">
                                                <label class="custom-control-label" for="vri">Status</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="st">
                                                <label class="custom-control-label" for="st">Status</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-tb-item -->
                    
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid1">
                                <label class="custom-control-label" for="uid1"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <a href="html/user-details-regular.html">
                                <div class="user-card">
                                    <div class="user-avatar bg-primary">
                                        <span>AB</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ms-1"></span></span>
                                        <span>info@softnio.com</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">35,040.34 <span class="currency">USD</span></span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span>+811 847-4958</span>
                        </div>
                        <div class="nk-tb-col tb-col-xl">
                            <ul class="list-status">
                                <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                            </ul>
                        </div>
                        <div class="nk-tb-col tb-col-xl">
                            <span>10 Feb 2020</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-status text-success">Active</span>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Approve</span></a></li>
                                                <li><a href="#"><em class="icon ni ni-na"></em><span>Decline</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-tb-item -->

                </div><!-- .nk-tb-list -->
            </div><!-- .card-inner -->
            <div class="card-inner">
                <div class="nk-block-between-md g-3">
                    <div class="g">
                        <!-- <ul class="pagination justify-content-center justify-content-md-start">
                            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item"><a class="page-link" href="#">7</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul> -->
                        <!-- .pagination -->
                    </div>
                    <div class="g">
                        <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                            <div>Page</div>
                            <div>
                                <select class="form-select js-select2" data-search="on" data-dropdown="xs center" id="select-page">
                                    <option value="page-1">1</option>
                                </select>
                            </div>
                            <div id="total-page">of 0</div>
                        </div>
                    </div><!-- .pagination-goto -->
                </div><!-- .nk-block-between -->
            </div><!-- .card-inner -->
        </div><!-- .card-inner-group -->
    </div><!-- .card -->
</div><!-- .nk-block -->
