@extends('layout.main')
@section('content')
<div class="page-container">
    @include('component.navigation')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Servers</h2>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#AddServer">Lunch Server</button>
                        </div>
                    </div>
                </div>

                <div class="row m-t-30">
                    <div class="col-md-12">
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-server">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>VPS ID</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Stop</th>
                                        <th>Power OFF</th>
                                        <th>Start</th>
                                        <th>Reboot</th>
                                        <th>Terminate</th>
                                        <th>VPS Instance</th>
                                        <th>Manipulate</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddServer" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Lunch Server</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="template" class="control-label mb-1">Select Server Template</label>
                            <select id="template" name="template" class="form-control js-example-basic-single">
                                <option value="">Select Server Template</option>
                            </select>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                            <label for="server_os" class="control-label mb-1">Select Server Operating System</label>
                            <select id="server_os" name="server_os" class="form-control">
                                <option value="">Select Server Operating System</option>
                            </select>
                        </div>
                    
                        <div class="col-sm-6 form-group">
                            <label for="region" class="control-label mb-1">Select Server Region</label>
                            <select id="region" name="region" class="form-control">
                                <option value="">Select Server Region</option>
                            </select>
                        </div>

                        <div class="col-sm-6">
                            <label for="server_name" class="control-label mb-1">Server Name</label>
                            <input type="text" id="server_name" name="server_name" class="form-control" placeholder="Enter Server Name" required>
                        </div>

                        <div class="col-12 text-right">
                            <button type="button" class="au-btn au-btn-icon au-btn--green au-btn--small" id="lunchServer" onclick="LunchServe()">Lunch Server</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="manipulate-server" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Manipulate Server</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row ">

                        <input type="hidden" id="server_id" name="server_id" class="form-control" placeholder="Enter Server Name" required>

                        <input type="hidden" id="verifiedSessionId" name="verifiedSessionId" class="form-control" placeholder="Enter Server Name" required>

                        <input type="hidden" id="secret" name="secret" class="form-control" placeholder="Enter Server Name" required>
                        
                        <div class="col-sm-6">
        <label for="action" class="control-label mb-1">Action</label>
        <select id="action" name="action" class="form-control js-example-basic-single">
            <option value="">Select Action</option>
            <option value="STOP">STOP</option>
            <option value="START">START</option>
            <option value="POWER_OFF">POWER_OFF</option>
            <option value="REBOOT">REBOOT</option>
            <option value="TERMINATE">TERMINATE</option>
            <option value="ENABLE_CONSOLE_ACCESS">ENABLE_CONSOLE_ACCESS</option>
            <option value="DISABLE_CONSOLE_ACCESS">DISABLE_CONSOLE_ACCESS</option>
            <option value="ENABLE_RESCUE_MODE">ENABLE_RESCUE_MODE</option>
            <option value="DISABLE_RESCUE_MODE">DISABLE_RESCUE_MODE</option>
        </select>
    </div>

    <!-- Termination Reason (Hidden by Default) -->
    <div class="col-sm-6" id="termination_reason_container" style="display: none;">
        <label for="termination_reason" class="control-label mb-1">Termination Reason</label>
        <input type="text" id="termination_reason" name="termination_reason" class="form-control" placeholder="Enter Termination Reason">
    </div>
</div>

<div class="col-12 text-right mt-3">
    <button type="button" class="au-btn au-btn-icon au-btn--green au-btn--small" data-dismiss="modal" aria-label="Close" id="ManipulateServe" onclick="ManipulateServe()">Update</button>
</div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const path = `{{url('/')}}`;
    const myHeaders = new Headers();
    myHeaders.append("Authorization", `Bearer ${token}`);

    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow",
    };

    async function fetchDataAndPopulateDropdowns() {
        try {
            const [regionResponse, osResponse, templateResponse] = await Promise.all([
                fetch(`${BASE_URL}/vps/regions`, requestOptions),
                fetch(`${BASE_URL}/server/operating-systems`, requestOptions),
                fetch(`${BASE_URL}/server/templates`, requestOptions)
            ]);

            if (regionResponse.ok && osResponse.ok && templateResponse.ok) {
                const regionData = await regionResponse.json();
                const osData = await osResponse.json();
                const templateData = await templateResponse.json();

                populateDropdown('template', templateData.items, 'id', 'name');
                populateDropdown('server_os', osData.items, 'id', 'name');
                populateDropdown('region', regionData.items, 'id', 'name');
            } else {
                console.error("Error fetching one or more APIs");
            }
        } catch (error) {
            console.error("Fetch error:", error);
        }
    }

    function populateDropdown(dropdownId, data, valueKey, textKey) {
        const dropdown = document.getElementById(dropdownId);
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item[valueKey];
            option.textContent = item[textKey];
            dropdown.appendChild(option);
        });
    }

    fetchDataAndPopulateDropdowns();
    
    // Lunch Server API Call
    async function LunchServe() {
        const template = document.getElementById("template").value;
        const serverOs = document.getElementById("server_os").value;
        const region = document.getElementById("region").value;
        const serverName = document.getElementById("server_name").value;

        if (!template || !serverOs || !region || !serverName) {
            showAlert("Please fill in all the fields." , 'error');
            return;
        }

        const myHeadersPost = new Headers();
        myHeadersPost.append("Content-Type", "application/json");
        myHeadersPost.append("Authorization", `Bearer ${token}`);

        const raw = JSON.stringify({
            "os": serverOs,
            "region": region,
            "template": template,
            "name": serverName
        });
                
        const requestOptionsPost = {
            method: "POST",
            headers: myHeadersPost,
            body: raw,
            redirect: "follow"
        };

        try {
            const apiUrl = `${BASE_URL}/server/launch`;

            const response = await fetch(apiUrl, requestOptionsPost);

            if (!response.ok) {
                throw new Error(`Server error occurred while launching: ${response.statusText}`);
            }

            const result = await response.json();
            showAlert("Server launched successfully!" , 'success');
        } catch (error) {
            showAlert("Launch error:" + error , 'error');
        }
    }
    
    async function ManipulateServe() {
  
        const server_id = document.getElementById("server_id").value;
        const action = document.getElementById("action").value;

        if (!server_id || !action) {
            showAlert("Please fill in all the fields." , 'error');
            return;
        }

        const myHeadersPost = new Headers();
        myHeadersPost.append("Content-Type", "application/json");
        myHeadersPost.append("Authorization", `Bearer ${token}`);

        const raw = JSON.stringify({
            server_id,
            action,
        });
                
        const requestOptionsPost = {
            method: "POST",
            headers: myHeadersPost,
            body: raw,
            redirect: "follow"
        };
        // console.log(action, server_id)
        // return;

        try {
            const apiUrl = `${BASE_URL}/servers/${server_id}/manipulate`;

            const response = await fetch(apiUrl, requestOptionsPost);

            if (!response.ok) {
                throw new Error(`Server error occurred while Manipulating: ${response.statusText}`);
            }

            const result = await response.json();
            showAlert("Server Manipulated successfully!" , 'success');
            fetchServersAndPopulateTable();
        } catch (error) {
            showAlert("Manipulate error:" + error , 'error');
        }
    }

    // Fetch Servers List API Call

    async function fetchServersAndPopulateTable() {
        try {
            const response = await fetch(`${BASE_URL}/servers?page=1&pageSize=100`, requestOptions);

            if (!response.ok) {
                throw new Error(`Failed to fetch server data: ${response.statusText}`);
            }

            const data = await response.json();
            populateServerTable(data.items);
        } catch (error) {
            console.error("Error fetching server data:", error);
        }
    }

    function populateServerTable(servers) {
        const tableBody = document.querySelector(".table-server tbody");
        tableBody.innerHTML = "";

        servers.forEach((server) => {
            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${server.id}</td>
                <td>${server.vpsId}</td>
                <td>${server.userId}</td>
                <td>${server.name}</td>
                <td class="text-uppercase">${server.status}</td>
                <td class="text-uppercase">${server.ableToStop}</td>
                <td class="text-uppercase">${server.ableToPowerOff}</td>
                <td class="text-uppercase">${server.ableToStart}</td>
                <td class="text-uppercase">${server.ableToReboot}</td>
                <td class="text-uppercase">${server.ableToTerminate}</td>
                <td class="text-uppercase">${server.vpsInstance || '-'}</td>
                <td><button class="manipulate-btn text-capitalize au-btn au-btn-icon au-btn--cornflowerblue au-btn--small" data-toggle="modal" data-target="#manipulate-server" data-id="${server.id}">Manipulate</button></td>
                <td><a href="${path}/server/detail/${server.id}" class="btn btn-info btn-sm">Detail</a></td>
            `;

            tableBody.appendChild(row);
        });
    }
    fetchServersAndPopulateTable();

    // $(document).on("click", ".manipulate-btn", function () {
    //     console.log($(this).data('id'));
    // });

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("manipulate-btn")) {
            const serverId = event.target.dataset.id;
            console.log(serverId)

            document.getElementById("server_id").value = serverId;
            // window.location.href = `${path}/server/manipulate/${serverId}`;
        }
    });
    document.getElementById("action").addEventListener("change", function () {
    const terminationReasonContainer = document.getElementById("termination_reason_container");

    if (this.value === "TERMINATE") {
        terminationReasonContainer.style.display = "block"; // Show the field
    } else {
        terminationReasonContainer.style.display = "none"; // Hide the field
    }
});
</script>

@endsection