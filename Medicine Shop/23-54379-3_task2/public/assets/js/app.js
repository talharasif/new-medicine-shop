document.addEventListener("DOMContentLoaded", () => {
    const esc = s => String(s ?? "").replace(/[&<>"']/g, c => ({
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;"
    }[c]));

    const debounce = (fn, ms = 250) => {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn(...args), ms);
        };
    };

    document.querySelectorAll("form[data-confirm]").forEach(form => {
        form.addEventListener("submit", e => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });

    const medicineForm = document.getElementById("medicineForm");

    if (medicineForm) {
        medicineForm.addEventListener("submit", e => {
            const price = Number(medicineForm.price.value);
            const stock = Number(medicineForm.availability.value);
            const image = medicineForm.image.files[0];

            if (price <= 0 || stock < 0) {
                e.preventDefault();
                alert("Price must be > 0 and stock cannot be negative.");
                return;
            }

            if (image && image.size > 2 * 1024 * 1024) {
                e.preventDefault();
                alert("Image must be 2MB or less.");
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Customer Search
    | Normal table actions: View + Delete
    |--------------------------------------------------------------------------
    */
    const customerSearch = document.getElementById("customerSearch");

    if (customerSearch) {
        const table = document.getElementById("customersTable");
        const body = table.querySelector("tbody");
        const csrf = table.dataset.csrf;

        const runCustomerSearch = async () => {
            try {
                const response = await fetch(
                    "index.php?action=customer_search_api&q=" +
                    encodeURIComponent(customerSearch.value)
                );

                const data = await response.json();

                body.innerHTML = data.rows.map(x => `
                    <tr>
                        <td>${esc(x.name)}</td>
                        <td>${esc(x.email)}</td>
                        <td>${esc(x.phone)}</td>
                        <td>${esc(x.address)}</td>
                        <td>
                            <a class="btn-link"
                               href="index.php?action=customer_details&id=${x.id}">
                               View
                            </a>
                            <a class="btn-link" href="index.php?action=customer_edit&id=${x.id}">Edit</a>
                            <form class="inline"
                                  method="post"
                                  action="index.php?action=customer_delete"
                                  onsubmit="return confirm('Delete customer and related records?')">
                                <input type="hidden"
                                       name="csrf_token"
                                       value="${esc(csrf)}">
                                <input type="hidden"
                                       name="id"
                                       value="${x.id}">
                                <button class="danger" type="submit">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                `).join("");
            } catch (error) {
                body.innerHTML =
                    '<tr><td colspan="5">Search failed.</td></tr>';
            }
        };

        customerSearch.addEventListener(
            "input",
            debounce(runCustomerSearch)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Medicine Search
    | Normal table actions: View + Edit + Delete
    |--------------------------------------------------------------------------
    */
    const medicineSearch = document.getElementById("medicineSearch");
    const medicineCategory = document.getElementById("medicineCategory");
    const medicineType = document.getElementById("medicineType");

    if (medicineSearch && medicineCategory && medicineType) {
        const table = document.getElementById("medicinesTable");
        const body = table.querySelector("tbody");
        const csrf = table.dataset.csrf;

        const runMedicineSearch = async () => {
            try {
                const params = new URLSearchParams({
                    action: "medicine_search_api",
                    q: medicineSearch.value,
                    category: medicineCategory.value,
                    type: medicineType.value
                });

                const response = await fetch("index.php?" + params);
                const data = await response.json();

                body.innerHTML = data.rows.map(x => `
                    <tr>
                        <td>${esc(x.name)}</td>
                        <td>
                            ${esc(x.category_name)}
                            /
                            ${esc(x.category_type)}
                        </td>
                        <td>${esc(x.vendor_name)}</td>
                        <td>${esc(x.price)}</td>
                        <td>${esc(x.availability)}</td>
                        <td>
                            ${x.image_path
                                ? `<img class="thumb"
                                        src="${esc(x.image_path)}"
                                        alt="Medicine">`
                                : ""}
                        </td>
                        <td>
                            <a class="btn-link"
                               href="index.php?action=medicine_details&id=${x.id}">
                               View
                            </a>

                            <a class="btn-link"
                               href="index.php?action=medicine_edit&id=${x.id}">
                               Edit
                            </a>

                            <form class="inline"
                                  method="post"
                                  action="index.php?action=medicine_delete"
                                  onsubmit="return confirm('Delete medicine?')">
                                <input type="hidden"
                                       name="csrf_token"
                                       value="${esc(csrf)}">
                                <input type="hidden"
                                       name="id"
                                       value="${x.id}">
                                <button type="submit" class="danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                `).join("");
            } catch (error) {
                body.innerHTML =
                    '<tr><td colspan="7">Search failed.</td></tr>';
            }
        };

        medicineSearch.addEventListener(
            "input",
            debounce(runMedicineSearch)
        );

        medicineCategory.addEventListener(
            "change",
            runMedicineSearch
        );

        medicineType.addEventListener(
            "change",
            runMedicineSearch
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Order Search
    | Normal table actions: Accept + Reject for pending orders
    |--------------------------------------------------------------------------
    */
    const orderSearch = document.getElementById("orderSearch");
    const orderFilter = document.getElementById("orderStatusFilter");
    const orderTable = document.getElementById("ordersTable");

    if (orderSearch && orderFilter && orderTable) {
        const body = orderTable.querySelector("tbody");

        const runOrderSearch = async () => {
            try {
                const params = new URLSearchParams({
                    action: "order_search_api",
                    q: orderSearch.value,
                    status: orderFilter.value
                });

                const response = await fetch("index.php?" + params);
                const data = await response.json();

                body.innerHTML = data.rows.map(x => `
                    <tr data-order="${x.id}">
                        <td>${x.id}</td>
                        <td>
                            ${esc(x.customer_name)}
                            <br>
                            <small>${esc(x.email)}</small>
                        </td>
                        <td>${esc(x.total_amount)}</td>
                        <td>${esc(x.shipping_address)}</td>
                        <td>${esc(x.order_date)}</td>
                        <td class="status">${esc(x.status)}</td>
                        <td>
                            ${x.status === "pending"
                                ? `
                                    <button class="status-btn"
                                            data-status="accepted">
                                        Accept
                                    </button>

                                    <button class="status-btn danger"
                                            data-status="rejected">
                                        Reject
                                    </button>
                                  `
                                : "Processed"}
                        </td>
                    </tr>
                `).join("");
            } catch (error) {
                body.innerHTML =
                    '<tr><td colspan="7">Search failed.</td></tr>';
            }
        };

        orderSearch.addEventListener(
            "input",
            debounce(runOrderSearch)
        );

        orderFilter.addEventListener(
            "change",
            runOrderSearch
        );

        orderTable.addEventListener("click", async e => {
            if (!e.target.classList.contains("status-btn")) return;

            const row = e.target.closest("tr");
            const status = e.target.dataset.status;
            const id = row.dataset.order;

            if (!confirm(`Change order to ${status}?`)) return;

            try {
                const response = await fetch(
                    "index.php?action=order_status_api",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            id: id,
                            status: status,
                            csrf_token: orderTable.dataset.csrf
                        })
                    }
                );

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message);
                }

                row.querySelector(".status").textContent = status;
                row.querySelector("td:last-child").textContent = "Processed";
            } catch (error) {
                alert(error.message);
            }
        });
    }
});
