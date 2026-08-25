@extends('adminlte::page')

@section('title', ($branch?->name ?? 'School') . ' Dashboard')


@section('content_header')

    <h1>{{ $branch?->name ?? 'School' }} Dashboard</h1>

@stop


@section('content')

<div class="row">


    {{-- =====================================================
         TOTAL STUDENTS
         ===================================================== --}}

    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>0</h3>

                <p>Total Students</p>

            </div>


            <div class="icon">

                <i class="bi bi-mortarboard-fill"></i>

            </div>

        </div>

    </div>



    {{-- =====================================================
         TOTAL TEACHERS
         ===================================================== --}}

    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>0</h3>

                <p>Total Teachers</p>

            </div>


            <div class="icon">

                <i class="bi bi-person-workspace"></i>

            </div>

        </div>

    </div>



    {{-- =====================================================
         TOTAL CLASSES
         ===================================================== --}}

    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>0</h3>

                <p>Total Classes</p>

            </div>


            <div class="icon">

                <i class="bi bi-building"></i>

            </div>

        </div>

    </div>



    {{-- =====================================================
         TOTAL PARENTS
         ===================================================== --}}

    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>0</h3>

                <p>Total Parents</p>

            </div>


            <div class="icon">

                <i class="bi bi-people-fill"></i>

            </div>

        </div>

    </div>


</div>

@stop