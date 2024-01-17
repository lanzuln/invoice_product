@extends('layout.master')
@section('body')
    <!--==================== INVOICE LIST ====================-->
    <div class="invoices">

        <div class="card__header">
            <div>
                <h2 class="invoice__title">Invoices</h2>
            </div>
            <div>
                <a class="btn btn-secondary" href="{{route('invoice.create')}}">
                    New Invoice
                </a>
            </div>
        </div>

        <div class="table card__content">
            <div class="table--filter">
                <span class="table--filter--collapseBtn ">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <div class="table--filter--listWrapper">
                    <ul class="table--filter--list">
                        <li>
                            <p class="table--filter--link table--filter--link--active">
                                All
                            </p>
                        </li>
                        <li>
                            <p class="table--filter--link ">
                                Paid
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <div class="table--search">
                <div class="table--search--wrapper">
                    <select class="table--search--select" name="" id="">
                        <option value="">Filter</option>
                    </select>
                </div>
                <div class="relative">
                    <i class="table--search--input--icon fas fa-search "></i>
                    <input class="table--search--input" type="text" placeholder="Search invoice">
                </div>
            </div> --}}



            <table class="" id="tableData" style="width: 100%">
                <thead>
                    <tr class="bg-light">
                        <th style="width: 5%">ID</th>
                        <th>Date</th>
                        <th>Number</th>
                        <th>Customer</th>
                        <th>Due Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tableList">
                    {{-- Table Data --}}
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

    <script>
        getList();


        async function getList() {


            let res = await axios.get("/all-invoice");

            let tableData = $('#tableData');
            let tableList = $('#tableList');

            tableData.DataTable().destroy();
            tableList.empty();


            res.data.forEach(function(item, index) {
                let row = `<tr>
                    <td>#${item.id}</td>
                    <td>${item.date}</td>
                    <td>${item.number}</td>
                    <td>${item.customer_id}</td>
                    <td>${item.due_date}</td>
                    <td>${item.total}</td>
                </tr>`;
                tableList.append(row);
            })


            tableData.DataTable({
                lengthMenu: [10, 15, 20, 25, 30, 35, 40, 45, 50],
                order: [
                    [0, 'ASC']
                ],
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    }
                }
            });
        }


        $('#tableData').dataTable({
            "autoWidth": false
        });
    </script>
@endsection
