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
                ${generateCardHeader(studyPartner, index)}
                ${generateCardBody(studyPartner, index)}
            </div>
        `;

        contentBody.appendChild(row);

        // Reinitialize the Bootstrap collapse functionality for the new elements
        const collapseElement = document.getElementById(`details-${index}`);
        const chevronIcon = row.querySelector('.chevron-icon');
        
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

function generateCardHeader(studyPartner, index) {
    return `
        <div class="row g-0 align-items-center pb-2 pt-md-2 pt-3">
            <div class="col-md-2 text-center">
                <img id="user-profile" src="${studyPartner.profile.profile_picture_filepath}" alt="User profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
            </div>
            ${generateCardContent(studyPartner)}
            ${generateCardSimilarity(studyPartner)}
            ${generateCardChevron(index)}
        </div>
    `;
}

function generateCardContent(studyPartner) {
    let iconDisplay = '';

    switch (studyPartner.connectionType) {
        case 0: 
            iconDisplay = `
                <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                    &emsp;<i class="fa-regular fa-bookmark text-primary fs-3"></i>
                </button>
            `;
            break;
        case 1:
            iconDisplay = `
                <button type="submit" class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none">
                    &emsp;<i class="fa-solid fa-bookmark text-primary fs-3"></i>
                </button>
            `;
            break;
        case 2:
            iconDisplay = `
                <button class="bookmark-inline d-inline-flex justify-content-center align-items-center bg-transparent border-0 p-0 text-decoration-none" disabled>
                    &emsp;<i class="fa fa-user-plus text-primary fs-5"></i>
                    <p class="text-primary ms-2 mb-0 align-middle">Added</p>
                </button>
            `;
            break;
    }

    return `
        <div class="col-md-7 text-start justify-content-center align-items-center">
            <div class="card-body">
                <span class="d-inline-flex align-items-center">
                    <p class="card-title fw-bold fs-5 mb-0 me-1">${studyPartner.profile.account_full_name}</p>
                    <p class="fst-italic text-muted mb-0 ms-1">(${studyPartner.profile.profile_nickname})</p>
                    <form class="d-inline-flex" method="POST" action="/study-partners-suggester/bookmarks/toggle">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="study_partner_profile_id" value="${studyPartner.profile.profile_id}">
                        <input type="hidden" name="operation_page_source" value="results">
                        ${iconDisplay}
                    </form>
                </span>
                ${generateCardDetails(studyPartner)}
            </div>
        </div>
    `;
}

function generateCardDetails(studyPartner) {
    return `
        <div class="row align-self-center text-muted">
            <div class="col-1 text-center"><i class="fa fa-university"></i></div>
            <div class="col-11">${studyPartner.profile.profile_faculty}</div>
        </div>
        <div class="row align-items-center text-muted">
            <div class="col-1 text-center"><i class="fa fa-id-badge"></i></div>
            <div class="col-11">${studyPartner.profile.account_matric_number}</div>
        </div>
        <div class="row align-items-center text-muted">
            <div class="col-1 text-center"><i class="fa fa-envelope"></i></div>
            <div class="col-11">${studyPartner.profile.account_email_address}</div>
        </div>
    `;
}

function generateCardSimilarity(studyPartner) {
    return `
        <div class="col-md-2 text-center">
            <h4 class="text-success">Similarity</h4>
            <h1 class="text-success mb-0">${(studyPartner.similarity).toFixed(2)}</h1>
        </div>
    `;
}

function generateCardChevron(index) {
    return `
        <div class="col-md-1 text-center">
            <button class="btn btn-muted toggle-details" data-bs-toggle="collapse" data-bs-target="#details-${index}">
                <i class="fa fa-chevron-down fs-1 chevron-icon"></i>
            </button>
        </div>
    `;
}

function generateCardBody(studyPartner, index) {
    let suggesterActionsRow = '';

    if (studyPartner.connectionType != 2) {
        suggesterActionsRow = `
            <div class="row">
                <div class="suggester-actions-row d-flex justify-content-center col-12 mb-4 px-0">
                    <form class="w-100 d-flex justify-content-center" method="POST" action='/study-partners-suggester/add-to-list'>
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                        <input type="hidden" name="operation_page_source" value="results">
                        <input type="hidden" name="study_partner_profile_id" value="${studyPartner.profile.profile_id}">
                        <a href="/view-user-profile?profile_id=${studyPartner.profile.profile_id}" class="section-button-extrashort rsans btn btn-secondary fw-semibold px-3 me-2">View profile</a>
                        <button type="submit" class="section-button-extrashort rsans btn btn-primary fw-semibold px-3 ms-2">Add to my list</button>
                    </form>
                </div>
            </div>
        `
    }

    return `
        <div id="details-${index}" class="collapse">
            <hr class="divider-gray-300 mb-4 mt-2">
            <div class="container px-2">
                ${suggesterActionsRow}
            </div>
        </div>
    `;
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
