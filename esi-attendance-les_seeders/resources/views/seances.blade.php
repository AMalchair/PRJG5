@extends('canvas')

@section('navigationMenu')
@include('partials.globalNavigation')
@endsection

@section('content')

<h1 id="title">Liste des séances</h1>

<form id="selectsFilters" method="get" action="{{ url('seances') }}">
    <span>Filtres : </span>
    <select name="id" id="teacherList">
        <option value="tous">Profs</option>
        @foreach($teachers as $teacher)
        <option value="{{$teacher->last_name}}">{{$teacher->last_name}}</option>
        @endforeach
    </select>
    <select name="today" id="today">
        <option value="false">Cours</option>
        <option value="true">Cours d'aujourd'hui</option>
    </select>
    <input type="submit">
</form>

<table id="seanceTable">
    <th>Cours</th>
    <th>Prof</th>
    <th>Groupe</th>
    <th>Date et heure</th>
    @foreach($seances as $seance)
    <tr dusk="trSeance" data-href="{{ route('studentsBySeance', ['id'=>$seance->id,'courseId'=>$seance->courseId,'teacherId'=>$seance->teacherId]) }}">
        <td class="courseName"> {{$seance->acronym}}</td>
        <td class="teacherLastName">{{$seance->last_name}}</td>
        <td class="groupe">{{$seance->groupId}}</td>
        <td class="dateTime">{{$seance->dateTime}}</td>
    </tr>
    @endforeach
</table>
<script type="text/javascript" src="{{ asset('js/clickableTableRow.js') }}"></script>
@endsection