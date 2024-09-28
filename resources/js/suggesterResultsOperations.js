document.addEventListener('DOMContentLoaded', function () {
    getSuggestedStudyPartners();
});

function getSuggestedStudyPartners() {
    fetch('/study-partners-suggester/suggester-results/get', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Successfully retrieved suggested study partners');
            generateSuggestedStudyPartnersList(data.suggestedStudyPartners);
            
        } else {
            console.log('Failed to retrieve suggested study partners');
        }
    })
    .catch(error => console.error('Error:', error));
}

function generateSuggestedStudyPartnersList(data) {
    const contentBody = document.getElementById('content-body');
    contentBody.innerHTML = '';  // Clear any previous content
    let index = 0;

    data.forEach(studyPartner => {
        const row = document.createElement('div');
        row.classList.add('row', 'pb-3');
        row.innerHTML = `
            <div class="rsans card suggested-sp-list-item h-100" id="suggested-sp-list-item-${index}">
                <div class="row g-0 align-items-center py-2">
                    <div class="col-md-2 text-center">
                        <img id="user-profile" src="${studyPartner.profile.profile_picture_filepath}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <!-- Content section -->
                    <div class="col-md-7 text-start justify-content-center align-items-center">
                        <div class="card-body">
                            <span class="d-inline-flex align-items-center">
                                <p class="card-title fw-bold fs-5 mb-0 me-1">
                                    ${studyPartner.profile.account_full_name}
                                </p>
                                <p class="fst-italic text-muted mb-0 ms-1">
                                    (${studyPartner.profile.profile_nickname})
                                </p>
                            </span>
                            <div class="row align-self-center text-muted">
                                <div class="col-1 text-center">
                                    <i class="fa fa-university"></i>
                                </div>
                                <div class="col-10">
                                    ${studyPartner.profile.profile_faculty}
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div class="row align-items-center text-muted">
                                <div class="col-1 text-center">
                                    <i class="fa fa-id-badge"></i>
                                </div>
                                <div class="col-10">
                                    ${studyPartner.profile.account_matric_number}
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div class="row align-items-center text-muted">
                                <div class="col-1 text-center">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="col-10">
                                    ${studyPartner.profile.account_email_address}
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Similarity section -->
                    <div class="col-md-2 text-center">
                        <h4 class="text-success">Similarity</h4>
                        <h1 class="text-success mb-0">${(studyPartner.similarity).toFixed(2)}</h1>
                    </div>
                    <!-- Dropdown chevron section -->
                    <div class="col-md-1 text-center">
                        <button class="btn btn-muted toggle-details"
                            data-bs-toggle="collapse"
                            data-bs-target="#details-${index}">
                            <i class="fa fa-chevron-down fs-1 chevron-icon"></i>
                        </button>
                    </div>
                    <!-- Collapsed section -->
                    <div id="details-${index}" class="collapse">
                        <hr class="divider-gray-300 mb-4">
                        <div class="container px-2">
                            <ul class="list-unstyled">
                                <li>
                                    <strong>Personal description:</strong><br>
                                    ${studyPartner.profile.profile_personal_desc}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `;
        contentBody.appendChild(row);

        // Reinitialize the Bootstrap collapse functionality for the new elements
        const collapseElement = document.getElementById(`details-${index}`);
        const chevronIcon = row.querySelector('.chevron-icon');
        
        // Ensure collapse starts hidden (if not already)
        collapseElement.classList.remove('show');

        // Add event listeners to toggle chevron rotation
        collapseElement.addEventListener('shown.bs.collapse', function () {
            chevronIcon.classList.add('rotate-chevron');  // Add rotation class when shown
        });

        collapseElement.addEventListener('hidden.bs.collapse', function () {
            chevronIcon.classList.remove('rotate-chevron');  // Remove rotation class when hidden
        });

        index++;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.toggle-details');

    toggleButtons.forEach(button => {
        const icon = button.querySelector('i');
        const targetId = button.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);

        // Rotate the chevron when the collapse starts showing
        targetElement.addEventListener('show.bs.collapse', function () {
            icon.classList.add('rotate-chevron');
        });

        // Reset the chevron when the collapse starts hiding
        targetElement.addEventListener('hide.bs.collapse', function () {
            icon.classList.remove('rotate-chevron');
        });
    });
});
