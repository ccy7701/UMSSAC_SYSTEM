<!-- resources/views/components/suggested-sp-list-item.blade.php -->
@props(['index'])
<div class="rsans card suggested-sp-list-item h-100" id="suggested-sp-list-item-{{ $index }}">
    <div class="row g-0 align-items-center py-2">
        <div class="col-md-2 text-center">
            <img id="user-profile" src="{{ asset('images/no_profile_pic_default.png') }}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <!-- Content section -->
        <div class="col-md-7 text-start justify-content-center align-items-center">
            <div class="card-body">
                <span class="d-inline-flex align-items-center">
                    <p class="card-title fw-bold fs-5 mb-0 me-1">account_full_name</p>
                    <p class="fst-italic text-muted mb-0 ms-1">
                        profile_nickname
                    </p>
                </span>
                <div class="row align-self-center text-muted">
                    <div class="col-1 text-center">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="col-10">
                        profile_faculty
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center">
                        <i class="fa fa-id-badge"></i>
                    </div>
                    <div class="col-10">
                        account_matric_number
                    </div>
                    <div class="col-1"></div>
                </div>
                <div class="row align-items-center text-muted">
                    <div class="col-1 text-center">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="col-10">
                        account_email_address
                    </div>
                    <div class="col-1"></div>
                </div>
            </div>
        </div>
        <!-- Similarity section -->
        <div class="col-md-2 text-center">
            <h4 class="text-success">Similarity</h4>
            <h1 class="text-success mb-0">X.XX</h1>
        </div>
        <!-- Dropdown chevron section -->
        <div class="col-md-1 text-center">
            <button class="btn btn-muted toggle-details"
                data-bs-toggle="collapse"
                data-bs-target="#details-{{ $index }}">
                <i class="fa fa-chevron-down fs-1 chevron-icon"></i>
            </button>
        </div>
        <!-- Collapsed section -->
        <div id="details-{{ $index }}" class="collapse">
            <hr class="divider-gray-300 mb-4">
            <div class="container px-2">
                <ul class="list-unstyled">
                    <li><strong>Full information 1:</strong> INDEX_{{ $index }}_INFO_1</li>
                    <li><strong>Full information 2:</strong> INDEX_{{ $index }}_INFO_2</li>
                    <li><strong>Full information 3:</strong> INDEX_{{ $index }}_INFO_3</li>
                </ul>
            </div>
        </div>
    </div>
</div>
