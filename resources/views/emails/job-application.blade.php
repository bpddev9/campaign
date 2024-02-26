<html>

<body
    style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
    <table
        style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
        <thead>
            <tr>
                <th style="text-align:left; display:flex; align-items:center; gap:15px">
                    <img style="max-width: 60px;" src="{{ asset('images/app-logo.png') }}" alt="{{ config('app.name') }}">
                    <div>
                        <span>{{ config('app.name') }}</span>
                        <small style="display: block; color:#979f9f">New Job Applied</small>
                    </div>
                </th>
                <th style="text-align:right;font-weight:700;">{{ date('jS F, Y', strtotime($job->created_at)) }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                    <p style="font-size:14px;margin:0 0 6px 0;text-align:center">
                        <span style="font-weight:bold;display:inline-block;min-width:150px">Application Status:</span>
                        <b style="color:green;font-weight:normal;margin:0">Successfully Applied</b>
                    </p>
                </td>
            </tr>


            <tr>
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px">Job Title</span>
                        {{ $job->jobTitle->position }}
                    </p>

                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px">Job Type</span>
                        {{ $job->job_type }}
                    </p>

                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px">Job Position</span>
                        {{ $job->job_position }}
                    </p>
                </td>

                <td style="width:50%;padding:20px;vertical-align:top">
                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">Location</span>
                        {{ $job->location_type }}
                    </p>

                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">No of People</span>
                        {{ $job->no_of_people }}
                    </p>

                    <p style="margin:0 0 10px 0;padding:0;font-size:14px;">
                        <span style="display:block;font-weight:bold;font-size:13px;">Job Schedule</span>
                        {{ $job->job_schedule }}
                    </p>
                </td>
            </tr>


            <tr>
                <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Applicant Details</td>
            </tr>
            <tr>
                <td colspan="2" style="padding:15px;">
                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                        <span style="display:block;font-size:13px;font-weight:normal;">Name:</span>
                        {{ $user->name }}
                    </p>

                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span
                            style="display:block;font-size:13px;font-weight:normal;">Email:</span>
                        {{ $user->email }}
                    </p>

                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span
                            style="display:block;font-size:13px;font-weight:normal;">Phone:</span>
                        {{ $user->phone_no }}
                    </p>

                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span
                            style="display:block;font-size:13px;font-weight:normal;">Street:</span>
                        {{ optional($user->profile)->street_address }}
                    </p>

                    <p style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;"><span
                            style="display:block;font-size:13px;font-weight:normal;">Address:</span>
                        {{ optional($user->profile)->city }}, {{ optional($user->profile)->state }},
                        {{ optional($user->profile)->zip_code }}
                    </p>

                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
