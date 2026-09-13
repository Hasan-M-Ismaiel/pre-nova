```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Proposal from novALight
    </title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background: #f5f5f5;
    font-family: Arial, Helvetica, sans-serif;
">

    <div style="
        max-width: 650px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
    ">

        {{-- Header --}}

        <div style="
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        ">

            <h2 style="
                margin: 0;
                font-size: 24px;
            ">
                novALight
            </h2>

        </div>


        {{-- Content --}}

        <div style="
            padding: 40px;
        ">

            <p>
                Hello {{ $proposal->client_name }},
            </p>

            <p>
                We are pleased to share the following proposal
                with you.
            </p>

            <h2 style="
                margin-top: 30px;
                margin-bottom: 10px;
            ">
                {{ $proposal->title }}
            </h2>


            @if($proposal->amount !== null)

                <p style="
                    font-size: 18px;
                    font-weight: bold;
                ">
                    Proposal Value:
                    ${{ number_format($proposal->amount, 2) }}
                </p>

            @endif


            <p style="
                color: #666666;
                line-height: 1.7;
            ">
                Please review the complete proposal using
                the button below.
            </p>


            {{-- Button --}}

            <div style="
                text-align: center;
                margin: 35px 0;
            ">

                <a
                    href="{{ url('/proposals/' . $proposal->token) }}"
                    style="
                        display: inline-block;
                        padding: 14px 28px;
                        background: #111111;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 6px;
                        font-weight: bold;
                    "
                >
                    View Proposal
                </a>

            </div>


            <p style="
                color: #777777;
                font-size: 14px;
                line-height: 1.6;
            ">
                You can review the proposal and choose to
                approve or reject it directly from the proposal page.
            </p>


            <p style="
                margin-top: 35px;
            ">
                Best regards,<br>
                <strong>novALight</strong>
            </p>

        </div>


        {{-- Footer --}}

        <div style="
            padding: 20px;
            text-align: center;
            background: #fafafa;
            color: #888888;
            font-size: 12px;
        ">

            This email was sent by novALight.

        </div>

    </div>

</body>

</html>
```
