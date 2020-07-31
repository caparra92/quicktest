<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>{{$test->title}}</title>
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
            padding-bottom: 15px;
            font-size: 12px;
        }

        .paginate {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
            font-weight: 1rem;
            padding-bottom: 15px;
            border-bottom: 1px solid black;
            font-size: 12px;
        }

        .textHeader {
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 0;
            font-weight: 1rem;
            padding-bottom: 15px;
            padding-top: 20px;
            font-size: 16px;
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
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .bubble {
            display: inline;
            text-align: center;
            background: lightblue;
            border: 1px solid black;
            border-radius: 50%;
            margin: 8px;
            padding: 8px;
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

        #lineAnswer {
            font-weight: 1px;
            color: black;
        }

        hr {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    @for($i = 0; $i <= $numberOfTests; $i++) 
    <table>
        <tr>
            <td class="paginate" colspan="3">Test {{$i+1}} of {{$numberOfTests}}</td>
        </tr>
        </table>

        <!-- render tests -->
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
                        ________________________________
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
        <!-- Bubble sheet here -->
        @if($answersSheet === "firstSheet")
        <table style="page-break-after: always;">
            <tr>
                <td class="textHeader">Bubble Sheet</td>
            </tr>
            @foreach($test->questions as $key=>$question)
            <tr>
                <td>
                @if(count($question->answers) > 0)
                    <strong>{{$key+1}}.</strong>
                    @foreach($question->answers as $answer)
                    <div class="bubble">{{$answer->letter}}</div>
                    @endforeach
                @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif
        <table>
            <tr>
                <td colspan="3" class="textHeader">
                    Test instructions
                </td>
            </tr>
            <tr>
                <td colspan="3" class="page">
                    {{$test->description}}
                </td>
            </tr>
        </table>
        <!-- QRcode here -->
        <!--  questions here -->
        <table id="questions" style="page-break-after: always;">
        @if($randomize === "questionsAndAnswers")
            @foreach($test->questions->shuffle()->all() as $key=>$question)
            <tr>
                <td class="question">
                    <span>{{$key+1}})</span> {{$question->description}}
                    @if($question->type === "open")
                        @for($i = 0; $i < $question->lines_answer; $i++)
                        <hr id="lineAnswer"/>
                        @endfor
                    @else
                        @foreach($question->answers->shuffle()->all() as $answer)
                        <p>{{$answer->letter}}) {{$answer->description}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            @endforeach
        @elseif($randomize === "onlyQuestions")
            @foreach($test->questions->shuffle()->all() as $key=>$question)
            <tr>
                <td class="question">
                    <span>{{$key+1}})</span> {{$question->description}}
                    @if($question->type === "open")
                        @for($i = 0; $i < $question->lines_answer; $i++)
                        <hr id="lineAnswer"/>
                        @endfor
                    @else
                        @foreach($question->answers as $answer)
                        <p>{{$answer->letter}}) {{$answer->description}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            @endforeach
        @elseif($randomize === "onlyAnswers")
            @foreach($test->questions as $key=>$question)
            <tr>
                <td class="question">
                    <span>{{$key+1}})</span> {{$question->description}}
                    @if($question->type === "open")
                        @for($i = 0; $i < $question->lines_answer; $i++)
                        <hr id="lineAnswer"/>
                        @endfor
                    @else
                        @foreach($question->answers->shuffle()->all() as $answer)
                        <p>{{$answer->letter}}) {{$answer->description}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            @endforeach
        @else
            @foreach($test->questions as $key=>$question)
            <tr>
                <td class="question">
                    <span>{{$key+1}})</span> {{$question->description}}
                    @if($question->type === "open")
                        @for($i = 0; $i < $question->lines_answer; $i++)
                        <hr id="lineAnswer"/>
                        @endfor
                    @else
                        @foreach($question->answers as $answer)
                        <p>{{$answer->letter}}) {{$answer->description}}</p>
                        @endforeach
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
        </table>
        <!-- Bubble sheet here -->
        @if($answersSheet === "individualSheet")
        <table style="page-break-after: always;">
            <tr>
                <td class="textHeader">Bubble Sheet</td>
            </tr>
            @foreach($test->questions as $key=>$question)
            <tr>
                <td>
                @if(count($question->answers) > 0)
                    <strong>{{$key+1}}.</strong>
                    @foreach($question->answers as $answer)
                    <div class="bubble">{{$answer->letter}}</div>
                    @endforeach
                @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif
        <!-- final render tests -->
    @endfor
</body>

</html>