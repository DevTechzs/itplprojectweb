<link href="assets/css/performance.css" rel="stylesheet" />

<!--this f-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="maincontent">
    <section class="content">
        <div class="container-fluid">
            <div class="performance-container">
                <button type="button" class="btn btn-outline-light" id=copyBtn>Copy</button>

                <div class="search-options">
                    <h2>Employees</h2>
                    <input type="text" id="emp-id" onkeyup="searchById()" placeholder="search by id"
                        title="Type employee Id" class="mb-3 p-2 w-25">

                    <input type="text" id="emp-name" onkeyup="searchByName()" placeholder="search by name"
                        title="Type in a name" class="mb-3 p-2 w-25">
                    <!-- Add this section within your .performance-container -->
                    <label for="departmentFilter">Filter by Department:</label>
                    <select id="departmentFilter" onchange="filterByDepartment()" class="mb-3 p-2 w-25">
                        <option value="all">All Departments</option>
                        <option value="IT">IT</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Finance">Finance</option>
                        <option value="Sales">Sales</option>
                        <option value="HR">HR</option>
                        <option value="CustomerSupport">Customer Support</option>
                    </select>

                </div>

                <div class="card-body table-responsive p-0" style="max-height:420px;">
                    <table class="table table-head-fixed text-nowrap performance-table" id="table-data">
                        <thead>
                            <tr>
                                <th class="performance-table-head">ID</th>
                                <th class="performance-table-head">Name</th>
                                <th class="performance-table-head">Department</th>
                                <th class="performance-table-head">Designation</th>
                                <th class="performance-table-head">Overall</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <a href="performance-individualPerformance" type="button"
                                        class="btn btn-outline-light">183</a></td>
                                <td>John Doe </td>
                                <td>HR</td>
                                <td>Manager</td>
                                <td><span class="tag tag-success">5</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">219</a></td>
                                <td>Alexander Pierce</td>
                                <td>Finance</td>
                                <td>Analyst</td>
                                <td><span class="tag tag-warning">3</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">654</a></td>
                                <td>Bob Doe</td>
                                <td>Marketing</td>
                                <td>Coordinator</td>
                                <td><span class="tag tag-primary">4</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">175</a></td>
                                <td>Mike Doe</td>
                                <td>IT</td>
                                <td>Developer</td>
                                <td><span class="tag tag-danger">2</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">134</a></td>
                                <td>Jim Doe</td>
                                <td>Sales</td>
                                <td>Representative</td>
                                <td><span class="tag tag-success">4</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">494</a></td>
                                <td>Victoria Doe</td>
                                <td>HR</td>
                                <td>Recruiter</td>
                                <td><span class="tag tag-warning">3</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">112</a></td>
                                <td>Michael Doe</td>
                                <td>Finance</td>
                                <td>Manager</td>
                                <td><span class="tag tag-primary">5</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">226</a></td>
                                <td>Rocky Doe</td>
                                <td>IT</td>
                                <td>System Analyst</td>
                                <td><span class="tag tag-danger">2</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">99</a></td>
                                <td>Linda Doe</td>
                                <td>Sales</td>
                                <td>Supervisor</td>
                                <td><span class="tag tag-success">4</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">120</a></td>
                                <td>Sarah Doe</td>
                                <td>Marketing</td>
                                <td>Manager</td>
                                <td><span class="tag tag-warning">3</span></td>
                            </tr>
                            <tr>
                                <td><a href="" type="button" class="btn btn-outline-light">133</a></td>
                                <td>Chris Doe</td>
                                <td>HR</td>
                                <td>Coordinator</td>
                                <td><span class="tag tag-primary">4</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function() {
    $("#copyBtn").on("click",
        function(e) {
            copyTable("table-data", e);
        });

});

function copyTable(el, e) {
    e.preventDefault();
    var table = document.getElementById(el);

    if (navigator.clipboard) {
        var text = table.innerText.trim();
        navigator.clipboard.writeText(text).catch(function() {});
    }
}
</script>


<script>
function searchById() {
    var input, filter, table, tr, td, i, txtValue;
    input = $("#emp-id");
    filter = input.val().toUpperCase();
    table = $(".performance-table");
    tr = table.find("tbody tr");

    for (i = 0; i < tr.length; i++) {
        td = tr.eq(i).find("td").eq(0); // Assuming employee ID is in the first column (index 0)
        if (td) {
            txtValue = td.text() || td.val();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr.eq(i).show();
            } else {
                tr.eq(i).hide();
            }
        }
    }
}

function searchByName() {
    var input, filter, table, tr, td, i, txtValue;
    input = $("#emp-name");
    filter = input.val().toUpperCase();
    table = $(".performance-table");
    tr = table.find("tbody tr");

    for (i = 0; i < tr.length; i++) {
        td = tr.eq(i).find("td").eq(1); // Assuming employee name is in the second column (index 1)
        if (td) {
            txtValue = td.text();
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr.eq(i).show();
            } else {
                tr.eq(i).hide();
            }
        }
    }
}
</script>


<script>
function filterByDepartment() {
    var departmentFilter = document.getElementById("departmentFilter").value;
    var table = document.querySelector(".performance-table");
    var rows = table.getElementsByTagName("tr");

    for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip the header row
        var departmentCell = rows[i].getElementsByTagName("td")[2]; // Assuming department is in the third column
        var display = departmentFilter === "all" || departmentCell.textContent.toUpperCase() === departmentFilter
            .toUpperCase();
        rows[i].style.display = display ? "" : "none";
    }
}
</script>