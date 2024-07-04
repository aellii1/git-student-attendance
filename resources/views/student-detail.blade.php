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
    <td>
        {{ $student->time_out ? \Carbon\Carbon::parse($student->time_out)->format('h:i:s A') : 'N/A' }}
    </td>
</tr>