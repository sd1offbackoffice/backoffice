@extends('navbar')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="tableFixedHeader testtable">
                    <table class="table table-sm table-hover table-bordered" id="tbl">
                        <thead>
                        {{--<tr>--}}
                            {{--<th scope="col">#</th>--}}
                            {{--<th scope="col">First</th>--}}
                            {{--<th scope="col">Last</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                            {{--<th scope="col">Handle</th>--}}
                        {{--</tr>--}}
                        <tr>
                            <th rowspan="2" >No</th>
                            <th rowspan="2" >Kodeigr</th>
                            <th rowspan="2" >Date</th>
                            <th rowspan="2">Action</th>
                            <th colspan="3">ISAKU</th>
                            <th scope="col">Cabang</th>
                            <th scope="col">Interface</th>
                            <th scope="col">Qv</th>
                            {{--<th colspan="3">KREDIT</th>--}}
                            {{--<th colspan="3">KUM</th>--}}
                        </tr>
                        {{--<tr class="">--}}
                            {{--<th scope="col" class="">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                            {{--<th scope="col">Cabang</th>--}}
                            {{--<th scope="col">Interface</th>--}}
                            {{--<th scope="col">Qv</th>--}}
                        {{--</tr>--}}
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>the Bird</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>@twitter</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2</td>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>the Bird</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr><tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>@fat</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>Larry</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr><tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr><tr>
                            <td>1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <style>
        /*.tableFixedHeader          { overflow-y: auto; height: 300px; }*/
        /*.tableFixedHeader thead th { position: sticky; top: 0; }*/
        /*.tableFixedHeader th     { background:#eee; }*/
        /*.tableFixedHeader table  { border-collapse: collapse; width: 100%; }*/
        /*.tableFixedHeader th, td { padding: 8px 16px; }*/

        .testtable {
            /*max-width: 500px;*/
        }

        .fixTheadforTwoRow{
            position: fixed;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#tbl').DataTable();
        })
    </script>
@endsection





