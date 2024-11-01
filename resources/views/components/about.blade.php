<!-- resources/views/components/about.blade.php -->
<div class="rsans modal fade" id="about-modal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 d-flex align-items-center">
                <p class="fw-semibold fs-5 mb-0" id="about-modal-label">
                    About UMSSACS
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-3">
                <div class="row d-flex justify-content-center align-items-center">
                    <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="w-60 mt-2">
                    <h5 class="text-center mt-3 fw-bold">University Malaysia Sabah<br>Student Academic Companion System</h5>
                </div>
                <hr class="divider-gray-300 py-2 mb-2">
                <div class="row text-start">
                    @php
                        $changeLogPath = base_path('storage/changelog.json');
                        $changeLog = [];
                        if (file_exists($changeLogPath)) {
                            $changeLog = json_decode(file_get_contents($changeLogPath), true);
                        }
                    @endphp
                    <table class="about-body" aria-hidden="true">
                        @foreach ($changeLog as $logEntry)
                            <tr>
                                <td class="px-3">
                                    <b>Version {{ $logEntry['version'] ?? 'N/A' }}</b><br>
                                    <ul>
                                        @foreach ($logEntry['changes'] ?? [] as $change)
                                            <li>{{ $change }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
