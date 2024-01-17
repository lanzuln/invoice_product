@extends('layout.master')
@section('body')
    <!--==================== NEW INVOICE ====================-->
    <div class="invoices">

        <div class="card__header">
            <div>
                <h2 class="invoice__title">New Invoice</h2>
                <div style="display: block">
                    <a class="btn btn-secondary" href="{{url('/')}}">
                        All Invoice
                    </a>
                </div>
            </div>
            <div>

            </div>
        </div>

        <div class="card__content">

            <div class="card__content--header">

                <div>

                    <p class="my-1">Customer</p>
                    <select name="" id="customer" class="input">

                    </select>
                </div>
                {{-- ====================== get customer  --}}
                <script>
                    getCustomer();
                    async function getCustomer() {
                        let res = await axios.get("/customer-list");
                        let customer = $('#customer');
                        res.data.forEach(function(item, index) {

                            let option = `<option value="${item.id}">${item.firstname}</option>`;
                            customer.append(option);
                        })
                    }
                </script>
                <div>
                    <p class="my-1">Date</p>
                    <input id="date" placeholder="dd-mm-yyyy" type="date" class="input"> <!---->
                    <p class="my-1">Due Date</p>
                    <input id="due_date" type="date" class="input">
                </div>
                <div>
                    <p class="my-1">Numero</p>
                    <input type="text" class="input">
                    <p class="my-1">Reference(Optional)</p>
                    <input type="text" class="input" name="reference">
                </div>
            </div>
            <br><br>
            <div class="table">

                <table class="table w-100" id="invoiceTable">
                    <thead class="w-100">
                        <tr class="text-xs">
                            <td>Item Description</td>
                            <td>Unit Price</td>
                            <td>QTY</td>
                            <td>total</td>
                            <td>Remove</td>
                        </tr>
                    </thead>
                    <tbody class="w-100" id="invoiceList">

                    </tbody>
                </table>
                <script>
                    let InvoiceItemList = [];

                    // ... Populate InvoiceItemList with items

                    // Call the ShowInvoiceItem function after populating InvoiceItemList
                    ShowInvoiceItem();

                    // Function to remove an item from InvoiceItemList
                    function removeItem(index) {
                        InvoiceItemList.splice(index, 1);
                        ShowInvoiceItem(); // Refresh the displayed items after removal
                    }

                    // Function to display and manage invoice items
                    function ShowInvoiceItem() {
                        let invoiceList = $('#invoiceList');
                        invoiceList.empty();

                        let totalSum = 0; // Variable to store the total sum of prices

                        InvoiceItemList.forEach(function (item, index) {
                            let quantity = 1; // Initial quantity
                            let total_price = (parseFloat(item['unit_price']) * quantity).toFixed(2);

                            // Increment totalSum with the current total_price
                            totalSum += parseFloat(total_price);

                            let row = `<tr class="text-xs">
                                <td>${item['item_code']} - (${item['description']})</td>
                                <td>${item['unit_price']}</td>
                                <td>
                                    <input type="number" value="${quantity}" class="quantity-input" data-index="${index}">
                                </td>
                                <td>
                                    <span class="total-price">${total_price}</span>
                                </td>
                                <td>
                                    <button class="btn btn-outline-danger remove" data-index="${index}">Remove</button>
                                </td>
                            </tr>`;

                            invoiceList.append(row);
                        });

                        // Update the "Total" field with the totalSum
                        $('#totalField').text(totalSum.toFixed(2));

                        // Attach event listener to dynamically update total price on quantity change
                        invoiceList.on('input', '.quantity-input', function () {
                            let index = $(this).data('index');
                            let newQuantity = parseFloat($(this).val());

                            // Update the displayed quantity
                            InvoiceItemList[index].quantity = newQuantity;

                            // Update the displayed total price
                            let newTotalPrice = (newQuantity * parseFloat(InvoiceItemList[index]['unit_price'])).toFixed(2);
                            $('.total-price').eq(index).text(newTotalPrice);

                            updateTotal();
                        });

                        // Attach event listener to remove button
                        $('.remove').on('click', function () {
                            let index = $(this).data('index');
                            removeItem(index);
                            updateTotal();
                        });

                        // Function to update the totalSum and the "Total" field
                        function updateTotal() {
                            totalSum = 0;
                            $('.total-price').each(function () {
                                totalSum += parseFloat($(this).text());
                            });
                            $('#totalField').text(totalSum.toFixed(2));
                        }
                    }
                </script>






                <div style="padding: 10px 30px !important;">
                    <button class="btn btn-sm btn__open--modal" data-bs-toggle="modal" data-bs-target="#add_product">Select
                        product</button>
                    <!-- Button trigger modal -->

                </div>
                @include('component.product-modal')
                {{-- =================== add product  --}}
            </div>

            <div class="table__footer">
                <div class="document-footer">
                    <p>Terms and Conditions</p>
                    <textarea cols="50" rows="7" class="textarea" name="terms_and_conditions"></textarea>
                </div>
                <div>
                    <div class="table__footer--subtotal">
                        <p>Sub Total</p>
                        <span id="sub_total">$ 0.00</span>
                    </div>
                    <div class="table__footer--discount">
                        <p>Discount</p>
                        <input type="text" class="input discount-input" name="discount">
                    </div>
                    <div class="table__footer--total">
                        <p>Grand Total</p>
                        <span id="total">$ 0.00</span>
                    </div>
                </div>
            </div>

            <script>

                // ... Populate InvoiceItemList with items

                // Call the ShowInvoiceItem function after populating InvoiceItemList
                ShowInvoiceItem();

                // Function to remove an item from InvoiceItemList
                function removeItem(index) {
                    InvoiceItemList.splice(index, 1);
                    ShowInvoiceItem(); // Refresh the displayed items after removal
                }

                // Function to display and manage invoice items
                function ShowInvoiceItem() {
                    let invoiceList = $('#invoiceList');
                    invoiceList.empty();

                    let subTotal = 0; // Variable to store the subtotal
                    let discount = 0; // Variable to store the discount

                    InvoiceItemList.forEach(function (item, index) {
                        let quantity = item.quantity || 1; // Initial quantity is 1 if not specified
                        let total_price = (parseFloat(item['unit_price']) * quantity).toFixed(2);

                        // Increment subTotal with the current total_price
                        subTotal += parseFloat(total_price);

                        let row = `<tr class="text-xs">
                            <td>${item['item_code']} - (${item['description']})</td>
                            <td>${item['unit_price']}</td>
                            <td>
                                <input type="number" value="${quantity}" class="quantity-input" data-index="${index}">
                            </td>
                            <td>
                                <span class="total-price">${total_price}</span>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger remove" data-index="${index}">Remove</button>
                            </td>
                        </tr>`;

                        invoiceList.append(row);
                    });

                    // Update the "Sub Total" field with the subTotal
                    $('.table__footer--subtotal span').text('$ ' + subTotal.toFixed(2));

                    // Update the "Grand Total" field considering the discount
                    updateGrandTotal();

                    // Attach event listener to dynamically update total price on quantity change
                    invoiceList.on('input', '.quantity-input', function () {
                        let index = $(this).data('index');
                        let newQuantity = parseFloat($(this).val());

                        // Update the displayed quantity
                        InvoiceItemList[index].quantity = newQuantity;

                        // Update the displayed total price
                        let newTotalPrice = (newQuantity * parseFloat(InvoiceItemList[index]['unit_price'])).toFixed(2);
                        $('.total-price').eq(index).text(newTotalPrice);

                        // Update Subtotal and Grand Total
                        updateSubtotal();
                        updateGrandTotal();
                    });

                    // Attach event listener to remove button
                    $('.remove').on('click', function () {
                        let index = $(this).data('index');
                        removeItem(index);
                        updateSubtotal();
                        updateGrandTotal();
                    });

                    // Attach event listener to discount input
                    $('.discount-input').on('input', function () {
                        updateGrandTotal();
                    });

                    // Function to update the Subtotal
                    function updateSubtotal() {
                        subTotal = 0;
                        $('.total-price').each(function () {
                            subTotal += parseFloat($(this).text());
                        });
                        $('.table__footer--subtotal span').text('$ ' + subTotal.toFixed(2));
                    }

                    // Function to update the Grand Total considering the discount
                    function updateGrandTotal() {
                        let discountValue = parseFloat($('.discount-input').val()) || 0;
                        discount = discountValue;
                        let grandTotal = subTotal - discount;
                        $('.table__footer--total span').text('$ ' + grandTotal.toFixed(2));
                    }
                }
            </script>



        </div>
        <div class="card__header" style="margin-top: 40px;">
            <div>

            </div>
            <div>
                <a class="btn btn-secondary" onclick="save()">
                    Save
                </a>
            </div>
        </div>

       </div>

       <script>
        async function save() {
            let customer_id = $("#customer").val();
            let date = $("#date").val();
            let due_date = $("#due_date").val();
            let reference = $("input[name='reference']").val();
            let terms_and_conditions = $("textarea[name='terms_and_conditions']").val();
            let discount = parseFloat($("input[name='discount']").val()) || 0;
            let sub_total = parseFloat($("#sub_total").text().replace('$ ', '')) || 0;
            let total = parseFloat($("#total").text().replace('$ ', '')) || 0;

            let Data = {
                "customer_id": customer_id,
                "date": date,
                "due_date": due_date,
                "reference": reference,
                "terms_and_conditions": terms_and_conditions,
                "discount": discount,
                "sub_total": sub_total,
                "total": total
            };

            if (!customer_id) {
                alert("Customer Required!");
            } else {

                try {
                    let res = await axios.post("/store-invoice", Data);

                    if (res.data.status === 'ok') {

                        alert("Invoice Created");
                    } else {
                        alert("Something Went Wrong");
                    }
                } catch (error) {

                    console.error(error);
                    errorToast("An error occurred while saving the invoice");
                }
            }
        }
    </script>
@endsection
