@extends('outline')

@section('body')

    <div class="row center-block">
        <div class="col-md-12 col-sm-12 panel">
            <div class="interiorpanel">
                <div class="row">
                    <h1 class="text-center">Stardew Valley Calendar</h1>
                </div>
                <div class="row hidden-xs">
                    <div class="col-xs-12">
                        <h3 class="text-center">
                            Find where the villagers are hiding
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var postURL = "{{ route('getSchedule') }}";
        var villagers = {!! $villagers->toJson() !!};
        var seasons = {!! $seasons->toJson() !!};
        var days = {!! $days->toJson() !!};
    </script>

    <div id="app">
        <schedules></schedules>
    </div>

    <div class="row center-block panel">
        <div class="interiorpanel">
            <div class="panel-heading">
                <h3>How to read the schedules</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    Read the panels from left to right. The first panel that applies should be the
                    villager's schedule for the day. There many be alternatives for rain, for buildings
                    being unavailable, or based on friendship that will override the regular schedule for
                    a day.
                </li>
                <li class="list-group-item">
                    If there are two panels for rain, there is an equal, random chance of either being picked.
                </li>
                <li class="list-group-item">
                    The times shown are when the villager will leave their previous location and head
                    to the listed location.
                </li>
                <li class="list-group-item">
                    If a villager has a location listed multiple times in a row, this normally means they're
                    moving around in a room / house.
                </li>
            </ul>
        </div>
    </div>

    <div class="row center-block panel text-center">
        <div class="interiorpanel">
            <p class="text-muted">
                Huge thanks to <a href="http://upload.farm">upload.farm</a> for allowing me to use their bootstrap theme
                <br />
                Source at [github link to follow]
                <br />
                All Stardew Valley assets copyright <a href="http://twitter.com/concernedape">Concerned Ape</a>
            </p>
        </div>
    </div>


@endsection