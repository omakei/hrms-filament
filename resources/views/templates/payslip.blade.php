
@extends('templates.layout')
@section('content')
    @include('templates.header', ['data' => $data])
    <div style="font-size: 9pt;" >
        <br/>
        <table width="100%" style="border-spacing: 0;">
            <thead>
            <tr>
                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="6">Employee Information</th>
            </tr>
            </thead>
            <tbody>
            <tr>

                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Employee Name: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ (\App\Models\Employee::find($data->employee_id))->full_name}}</td>
                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Gender: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{(\App\Models\Employee::find($data->employee_id))->gender}}</td>
                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Employee Number: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{(\App\Models\Employee::find($data->employee_id))->phone_1}}</td>
            </tr>
            <tr>

                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Employee Number: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ (\App\Models\Employee::find($data->employee_id))->employee_number}}</td>
                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Department: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{(\App\Models\Employee::find($data->employee_id))->department}}</td>
                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Status: </td>
                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{(\App\Models\Employee::find($data->employee_id))->status}}</td>
            </tr>
            </tbody>
        </table>
        <br/>
        <table width="100%" style="border-spacing: 0;">
            <thead>
            <tr>
                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="2">Salary Description</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="border:1px solid #000; text-align: center;padding: 0px;">
                    <table width="100%" style="border-spacing: 0;">
                        <tr>
                            <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Deduction</td>
                            <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Amount</td>
                        </tr>
                        @foreach($data->deductions as $deduction)
                            <tr>
                                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{$deduction->name}}</td>
                                <td style="border:1px solid #000; text-align: center;padding: 4px;">Tsh {{$deduction->pivot->amount}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="border:1px solid #000; text-align: center;padding: 0px;">
                    <table width="100%" style="border-spacing: 0;">
                        <tr>
                            <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Ernings</td>
                            <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Amount</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000; text-align: center;padding: 4px;">
                                {{$data->pay_scale->name}}</td>
                            <td style="border:1px solid #000; text-align: center;padding: 4px;">
                                {{$data->pay_scale->basic_salary}}</td>
                        </tr>
                        @foreach($data->allowances as $allowance)
                            <tr>
                                <td style="border:1px solid #000; text-align: center;padding: 4px;">{{$allowance->name}}</td>
                                <td style="border:1px solid #000; text-align: center;padding: 4px;">Tsh {{$allowance->pivot->amount}}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>

            </tr>
            <tr>
                <td style="border:1px solid #000; font-weight: bold; text-align: right;padding: 10px;">
                    Total Net Salary
                </td>
                <td style="border:1px solid #000; font-weight: bold; text-align: right;padding: 10px;">
                    Tsh {{
                     ($data->allowances->sum('pivot.amount') + $data->pay_scale->basic_salary) - $data->deductions->sum('pivot.amount')

}} /=                </td>
            </tr>
            </tbody>
        </table>
        <br/>
{{--        <table width="100%" style="border-spacing: 0;">--}}
{{--            <tr>--}}
{{--                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">On Going Examination: </td>--}}
{{--                <td style="border:1px solid #000; text-align: center;padding: 4px;">{!! $data->patient_examination !!}</td>--}}
{{--                <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">On Going Treatment: </td>--}}
{{--                <td style="border:1px solid #000; text-align: center;padding: 4px;">{!! $data->treatment_given !!}</td>--}}
{{--            </tr>--}}
{{--        </table>--}}
{{--        <br/>--}}
{{--        <table width="100%" style="border-spacing: 0;"> <thead>--}}
{{--            <tr>--}}
{{--                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="4">Diagnoses Information</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach((\App\Models\PatientVisit::find($data->patient_visit_id))->diagnoses as $diagnosis)--}}
{{--                <tr>--}}
{{--                    <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;"> Diagnosis Name: </td>--}}
{{--                    <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ $diagnosis->i_c_d10_code->code }}</td>--}}
{{--                    <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Diagnosis Type: </td>--}}
{{--                    <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ $diagnosis->type }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        <br/>--}}
{{--        <table width="100%" style="border-spacing: 0;">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th style="border:1px solid #000; text-align: center;padding: 4px;"  colspan="4">Investigations Information</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach((\App\Models\PatientVisit::find($data->patient_visit_id))->investigations as $investigation)--}}
{{--                <tr>--}}
{{--                    <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;"> Investigation Name: </td>--}}
{{--                    <td style="border:1px solid #000; text-align: center;padding: 4px;">{{ $investigation->laboratory_test->name }}</td>--}}
{{--                    <td style="border:1px solid #000; font-weight: bold; text-align: center;padding: 4px;">Investigation Result: </td>--}}
{{--                    <td style="border:1px solid #000; text-align: center;padding: 4px;">{!! $investigation->result !!}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
        <br/>
        <div>
            <h5> QR Code: </h5>
            <div><img src="data:image/svg+xml;base64,{{base64_encode($qrcode)}}"  width="120" height="120" /></div>
        </div>
    </div>
@endsection
