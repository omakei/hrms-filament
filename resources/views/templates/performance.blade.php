@extends('templates.layout')
@section('content')

    @include('templates.header_general', ['data' =>
['month' => now()->startOfMonth()->monthName, 'year' => now()->year, 'type' => 'PERFORMANCE REPORT']])
    <div style="font-size: 9pt;" >
        <br/>
        <table width="100%" style="border-spacing: 0;">
            <thead>
            <tr>
                <th style="border:1px solid #000; text-align: center;padding: 4px;"  >Employee Name</th>
                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="31">Performance Days</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $employee)
            <tr>
                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">{{$employee['employee_name']}}</td>
                @foreach($employee['performance'] as $day)
                    <td style="border:1px solid #000; text-align: center;padding: 4px;">
                        {{$day}}
                    </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
        <br/>
{{--        <table width="100%" style="border-spacing: 0;">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="2">Description Keys</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--           <tr>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >p</td>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >Present</td>--}}
{{--           </tr>--}}
{{--           <tr>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >a</td>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >Absent</td>--}}
{{--           </tr>--}}
{{--           <tr>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >l</td>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >On Leave</td>--}}
{{--           </tr>--}}
{{--           <tr>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >-</td>--}}
{{--               <td style="border:1px solid #000; text-align: left;padding: 4px;" >No Data</td>--}}
{{--           </tr>--}}

{{--            </tbody>--}}
{{--        </table>--}}
{{--        <br/>--}}

        <br/>
        <div>
            <h5> QR Code: </h5>
            <div><img src="data:image/svg+xml;base64,{{base64_encode($qrcode)}}"  width="120" height="120" /></div>
        </div>
    </div>
@endsection
