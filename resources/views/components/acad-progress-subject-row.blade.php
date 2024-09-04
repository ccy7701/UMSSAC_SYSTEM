<!-- COMPONENT: x-acad-progress-subject-row -->
@props(['code', 'subject_name', 'credit', 'grade', 'grade_point'])
<tr class="text-left align-middle">
    <td>{{ $code }}</td>
    <td>{{ $subject_name }}</td>
    <td>{{ $credit }}</td>
    <td>{{ $grade }}</td>
    <td>{{ number_format($grade_point, 2) }}</td>
    <!-- Edit tools column -->
    <td style="width: 1%;">
        <div class="dropdown">
            <button class="subject-row btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Edit</a></li>
                <li><a class="dropdown-item" href="#">Delete</a></li>
            </ul>
        </div>
    </td>
</tr>
