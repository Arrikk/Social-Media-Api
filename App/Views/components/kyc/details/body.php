
<div class="nk-block">
    <div class="row gy-5">
        <div class="col-lg-5">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title title">Application Info</h5>
                    <p>Submission date, approve date, status etc.</p>
                </div>
            </div><!-- .nk-block-head -->
            <div class="card card-bordered">
                <ul class="data-list is-compact">
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Submitted By</div>
                            <div class="data-value" id="submittedBy"><!-- USERNAME --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Submitted At</div>
                            <div class="data-value" id="submittedAt"><!-- CREATED DATE --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Status</div>
                            <div class="data-value" id="activeStatus"> <!-- STATUS --> </div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Last Checked</div>
                            <div class="data-value">
                                <div class="user-card" id="checkedBy">
                                    <!-- CHECKED BY -->
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Last Checked At</div>
                            <div class="data-value" id="checkedAt"><!-- CHECKED AT --></div>
                        </div>
                    </li>
                </ul>
            </div><!-- .card -->
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title title">Uploaded Documents</h5>
                    <p>Here is user uploaded documents.</p>
                </div>
            </div><!-- .nk-block-head -->
            <div class="card card-bordered" id="documentContainer">
                <ul class="data-list is-compact">
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Document Type</div>
                            <div class="data-value documentType"><!-- DOCUMENT TYPE --></div>
                            <div class="data-value"><!-- DOCUMENT TYPE --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Front Side</div>
                            <div class="data-value documentType" id="frontSide"><!-- DOCUMENT TYPE --></div>
                            <div class="data-value"><!-- DOCUMENT TYPE --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Back Side</div>
                            <div class="data-value documentType"><!-- DOCUMENT TYPE --></div>
                            <div class="data-value" id="backSide"><!-- DOCUMENT TYPE --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Proof/Selfie</div>
                            <div class="data-value documentType"><!-- DOCUMENT TYPE --></div>
                            <div class="data-value" id="selfie"></div>
                        </div>
                    </li>
                </ul>
            </div><!-- .card -->

        </div><!-- .col -->
        <div class="col-lg-7">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title title">Applicant Information</h5>
                    <p>Full info of kyc like, name, phone, address, country etc.</p>
                </div>
            </div>
            <div class="card card-bordered">
                <ul class="data-list is-compact">
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">First Name</div>
                            <div class="data-value" id="firstName"><!-- FIRST NAME --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Last Name</div>
                            <div class="data-value" id="lastName"><!-- LAST NAME --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Email Address</div>
                            <div class="data-value" id="emailAddress"><!-- EMAIL --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Phone Number</div>
                            <div class="data-value text-soft" id="phoneNumber"><em><!-- PHONE NUMBER --></em></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Date of Birth</div>
                            <div class="data-value" id="DOB"><!-- DOB --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Full Address</div>
                            <div class="data-value" id="fullAddress"><!-- ADDRESS --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Country</div>
                            <div class="data-value" id="country"><!-- COUNTRY --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Current Location</div>
                            <div class="data-value" id="currentLocation"><!-- ADDRESS  --></div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Wallet Type</div>
                            <div class="data-value">Bitcoin</div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Wallet Address</div>
                            <div class="data-value text-break">1F1tAaz5x1HUXrCNLbtMDqcw6o5GNn4xqX</div>
                        </div>
                    </li>
                    <li class="data-item">
                        <div class="data-col">
                            <div class="data-label">Amazon Url</div>
                            <div class="data-value" id="amazonUrl">
                                <!-- Amazon Url -->
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .col -->
    </div><!-- .row -->
</div><!-- .nk-block -->