<tr>
    <td>
        {{ strtoupper($student->student_name) }}
    </td>
    <td>
        {{ $student->student_lrn_no }}
    </td>
    <td>
        {{ $student->student_no }}
    </td>
    <td>
        {{ \Carbon\Carbon::parse($student->time_in)->format('h:i:s A') }}
    </td>
</tr>