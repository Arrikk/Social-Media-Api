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
                                <a href="javascript:;" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                            </li><!-- li -->
                            <li class="btn-toolbar-sep"></li><!-- li -->
                            <li>
                                <div class="toggle-wrap">
                                    <a href="javascript:;" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                    <div class="toggle-content" data-content="cardTools">
                                        <ul class="btn-toolbar gx-1">
                                            <li class="toggle-close">
                                                <a href="javascript:;" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                            </li><!-- li -->
                                            <li>
                                                <div class="dropdown">
                                                    <a href="javascript:;" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                        <div class="dot dot-primary"></div>
                                                        <em class="icon ni ni-filter-alt"></em>
                                                    </a>
                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-end">
                                                        <div class="dropdown-head">
                                                            <span class="sub-title dropdown-title">Filter Users</span>
                                                        </div>
                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-6 gy-3">
                                                                <div class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                        <label class="custom-control-label" for="hasBalance"> Have Balance</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                        <label class="custom-control-label" for="hasKYC"> KYC Verified</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Role</label>
                                                                        <select class="form-select js-select2">
                                                                            <option value="any">Any Role</option>
                                                                            <option value="investor">Investor</option>
                                                                            <option value="seller">Seller</option>
                                                                            <option value="buyer">Buyer</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                        <select class="form-select js-select2">
                                                                            <option value="any">Any Status</option>
                                                                            <option value="active">Active</option>
                                                                            <option value="pending">Pending</option>
                                                                            <option value="suspend">Suspend</option>
                                                                            <option value="deleted">Deleted</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-secondary">Filter</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot between">
                                                            <a class="clickable" href="javascript:;">Reset Filter</a>
                                                            <a href="javascript:;">Save Filter</a>
                                                        </div>
                                                    </div><!-- .filter-wg -->
                                                </div><!-- .dropdown -->
                                            </li><!-- li -->
                                            <li>
                                                <div class="dropdown">
                                                    <a href="javascript:;" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
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
                                                            <li><span>Order</span></li>
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
                            <a href="javascript:;" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
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
                        <div class="nk-tb-col"><span>User</span></div>
                        <div class="nk-tb-col tb-col-mb"><span>Doc Type</span></div>
                        <div class="nk-tb-col tb-col-md"><span>Documents</span></div>
                        <div class="nk-tb-col tb-col-lg"><span>Submitted</span></div>
                        <div class="nk-tb-col tb-col-md"><span>Status</span></div>
                        <div class="nk-tb-col tb-col-lg"><span>Checked By</span></div>
                        <div class="nk-tb-col nk-tb-col-tools">&nbsp;</div>
                    </div><!-- .nk-tb-item -->
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid1">
                                <label class="custom-control-label" for="uid1"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar bg-primary">
                                    <span>AB</span>
                                </div>
                                <div class="user-info">
                                    <span class="tb-lead">Abu Bin Ishtiyak <span class="dot dot-success d-md-none ms-1"></span></span>
                                    <span>UD01544</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col tb-col-mb">
                            <span class="tb-lead-sub">Passport</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <ul class="list-inline list-download">
                                <li>Front Side <a href="javascript:;" class="popup"><em class="icon ni ni-download"></em></a></li>
                                <li>Back Side <a href="javascript:;" class="popup"><em class="icon ni ni-download"></em></a></li>
                            </ul>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <span class="tb-date">18 Dec, 2019 01:02 PM</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-status text-success">Approved</span>
                            <span data-bs-toggle="tooltip" title="Approved at 18 Dec, 2019 01:02 PM" data-bs-placement="top"><em class="icon ni ni-info"></em></span>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <div class="user-card">
                                <div class="user-avatar user-avatar-xs bg-orange-dim">
                                    <span>JS</span>
                                </div>
                                <div class="user-name">
                                    <span class="tb-lead">Janet Snyder</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li class="nk-tb-action-hidden">
                                    <a href="html/kyc-details-regular.html" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View">
                                        <em class="icon ni ni-eye-fill"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="javascript:;" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Approved">
                                        <em class="icon ni ni-check-fill-c"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="javascript:;" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Rejected">
                                        <em class="icon ni ni-cross-fill-c"></em>
                                    </a>
                                </li>
                                <li>
                                    <div class="drodown">
                                        <a href="javascript:;" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="html/kyc-details-regular.html"><em class="icon ni ni-focus"></em><span>Quick View</span></a></li>
                                                <li><a href="html/kyc-details-regular.html"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                <li><a href="javascript:;"><em class="icon ni ni-user"></em><span>View Profile</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:;"><em class="icon ni ni-check-round"></em><span>Approved</span></a></li>
                                                <li><a href="javascript:;"><em class="icon ni ni-na"></em><span>Rejected</span></a></li>
                                                <li><a href="javascript:;"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-tb-item -->
                </div>
            </div><!-- .card-inner -->
            <div class="card-inner">
                <!-- <ul class="pagination justify-content-center justify-content-md-start">
                    <li class="page-item"><a class="page-link" href="javascript:;">Prev</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">1</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
                    <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">6</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">7</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">Next</a></li>
                </ul> -->

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
                <!-- .pagination -->
            </div><!-- .card-inner -->
        </div><!-- .card-inner-group -->
    </div><!-- .card -->
</div><!-- .nk-block -->