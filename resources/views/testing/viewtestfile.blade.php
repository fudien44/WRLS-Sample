<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
    </head>
    <body>
        This is the viewtestfile page!

        @if(session()->has('filePath'))
        <iframe
            src="{{asset('/')}}"
            width="100%"
            height="1200px"
            >This browser does not support PDFs. Please download the PDF to view
            it: Download PDF.</iframe
        >
        @endif
        <!-- <embed src="{{
                asset(
                    '/upload/Adam_Keizzer_Garcia_Sinsuat/Adam_Keizzer_Garcia_Sinsuat-user_issuance.pdf'
                )
            }}" type=”application/pdf” width=”100%” height=”100%”> -->
    </body>
</html>
