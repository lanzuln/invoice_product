<div class="modal" id='add_product' tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



                <table class="table  w-100" id="productTable">
                    <thead class="w-100">
                        <tr class="text-xs text-bold">
                            <td>Product</td>
                            <td>Pick</td>
                        </tr>
                    </thead>
                    <tbody class="w-100" id="productList">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<script>
    ProductList()
    async function ProductList() {

        let res = await axios.get("/product-list");
        let productList = $("#productList");



        res.data.forEach(function(item, index) {
            let row = `<tr class="text-xs">
                        <td> ${item.item_code}</td>
                        <td><a data-id="${item['id']}" data-item_code="${item['item_code']}" data-description="${item['description']}" data-unit_price="${item['unit_price']}" class="btn btn-outline-dark text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
                     </tr>`
            productList.append(row)
        })
        $('.addProduct').on('click', async function() {
            let id = $(this).data('id');
            let item_code = $(this).data('item_code');
            let description = $(this).data('description');
            let unit_price = $(this).data('unit_price');
            add(id, item_code, description, unit_price);


        })



    }

    function add(id, item_code, description, unit_price) {

        let newItem = {
            id: id,
            item_code: item_code,
            description: description,
            unit_price: unit_price
        };
        InvoiceItemList.push(newItem);
        console.log(InvoiceItemList);
        $('#add_product').modal('hide')
        ShowInvoiceItem();
    }


</script>
