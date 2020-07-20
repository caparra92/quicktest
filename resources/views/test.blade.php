<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            font-size: 16px;
        }

        table td {
            text-align: justify;
        }

        .page {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
            font-weight: 1rem;
            border-bottom: 1px solid black;
            padding-bottom: 15px;
            font-size: 12px;
        }

        .title {
            width: 10%;
            margin-right: 0;
        }

        .content {
            width: 55%;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .score {
            width: 10%;
            border: 2px solid black;
            margin-left: 20px;
            padding: 0;
            text-align: center;
        }

        .underline {
            border-bottom: 1px solid black;
        }

        .question {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #date {
            font-size: 14px;
        }

        #headers {
            margin-top: 20px;
        }

        #questions {
            margin-top: 20px;
            padding-top: 20px;
        }

        hr {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="page" colspan="3">Page 1 of 2</td>
        </tr>
    </table>
    <table id="headers">
        <tbody>
            <tr id="topTitle">
                <td class="title">
                    Teacher:
                </td>
                <td class="content">
                    {{ucwords($user_name->name)}}
                </td>
                <td rowspan="3" colspan="2" class="score">Score</td>
            </tr>
            <tr>
                <td class="title">
                    Signature:
                </td>
                <td class="content">
                    {{ucwords($signature->name)}}
                </td>
            </tr>
            <tr>
                <td class="title">
                    Course:
                </td>
                <td class="content">
                    {{$test->course}}
                </td>
            </tr>
            <tr>
                <td class="title">
                    Student:
                </td>
                <td>
                    __________________________________________________
                </td>
                <td class="title">
                    Date:
                </td>
                <td class="title" id="date">
                    {{date("d-m-yy",strtotime($test->date))}}
                </td>
            </tr>
        </tbody>
    </table>
    <!-- QRcode here -->
    <!--  questions here -->
    <table id="questions">
        @foreach($test->questions as $key=>$question)
        <tr>
            <td class="question">
                <span>{{$key+1}})</span> {{$question->description}}
                @foreach($question->answers as $answer)
            <p>{{$answer->letter}} - {{$answer->description}}</p>
                @endforeach
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>