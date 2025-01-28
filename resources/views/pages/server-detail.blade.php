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
                            <h2 class="title-1">Server Detail</h2>
                        </div>
                    </div>
                </div>

                <div class="row m-t-30">
                    <div class="col-md-12">
                        <!-- DATA TABLE-->
                        <div class="table-responsive m-b-40">
                            <table class="table table-borderless table-data3 table-sd">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Vps ID</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Stop</th>
                                        <th>Power Off</th>
                                        <th>Start</th>
                                        <th>Reboot</th>
                                        <th>Terminate</th>
                                        <th>Vps Intance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var serverId = `{{$id}}`;
    const myHeaders = new Headers();
    myHeaders.append("Authorization", `Bearer ${token}`);

    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow",
    };

    async function fetchServerDetail() {
        try {
            const response = await fetch(`${BASE_URL}/servers/${serverId}`, requestOptions);
            if (response.ok) {
                const result = await response.json();
                populateTable([result]);
            } else {
                console.error("Error:", response.statusText);
            }
        } catch (error) {
            console.error("Fetch error:", error);
        }
    }

    function populateTable(data) {
        const tableBody = document.querySelector(".table-sd tbody");
        tableBody.innerHTML = "";
        data.forEach((item, index) => {
            const row = `
                <tr>
                    <td>${item.id ?? '-'}</td>
                    <td>${item.vpsId ?? '-'}</td>
                    <td>${item.userId ?? '-'}</td>
                    <td>${item.name ?? '-'}</td>
                    <td class="text-uppercase">${item.status ?? '-'}</td>
                    <td class="text-uppercase">${item.ableToStop ?? '-'}</td>
                    <td class="text-uppercase">${item.ableToPowerOff ?? '-'}</td>
                    <td class="text-uppercase">${item.ableToStart ?? '-'}</td>
                    <td class="text-uppercase">${item.ableToReboot ?? '-'}</td>
                    <td class="text-uppercase">${item.ableToTerminate ?? '-'}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="toggleDetails(${index})">Details</button>
                    </td>
                </tr>
                <tr id="details-${index}" style="display: none;">
                    <td colspan="11">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                            <span class="detail-box">
                                Cpu Core: ${item.vpsInstance?.cpuCore ?? '-'}
                            </span>
                            <span class="detail-box">
                                Memory: ${item.vpsInstance?.memory ?? '-'}
                            </span>
                            <span class="detail-box">
                                Disk Size: ${item.vpsInstance?.diskSize ?? '-'}
                            </span>
                            <span class="detail-box">
                                OS: ${item.vpsInstance?.os ?? '-'}
                            </span>
                            <span class="detail-box">
                               Rescue Password : ${item.vpsInstance?.password ?? '-'}
                            </span>
                            <span class="detail-box">
                               VPS Username : ${item.vpsInstance?.vpsUsername ?? '-'}
                            </span>
                            <span class="detail-box">
                               Region : ${item.vpsInstance?.region ?? '-'}
                            </span>
                            <span class="detail-box">
                               Public IpV4 : ${item.vpsInstance?.publicIpV4 ?? '-'}
                            </span>
                            <span class="detail-box">
                               Console Access : <span class="text-uppercase">${item.vpsInstance?.consoleAccessStatus ?? '-'}</span>
                            </span>
                            <span class="detail-box">
                               Console Enabled : <span class="text-uppercase"> ${item.vpsInstance?.consoleAccessEnabled ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Console Enabling : <span class="text-uppercase">${item.vpsInstance?.consoleAccessEnabling ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Console Disabling : <span class="text-uppercase"> ${item.vpsInstance?.consoleAccessDisabling ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Console Url : <span class="text-uppercase"> ${item.vpsInstance?.consoleAccessUrl ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Console Password : <span class="text-uppercase"> ${item.vpsInstance?.consoleAccessPassword ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Console Code : <span class="text-uppercase"> ${item.vpsInstance?.consoleAccessCode ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Rescue Mode Enabled : <span class="text-uppercase"> ${item.vpsInstance?.rescueModeEnabled ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Rescue Enabling : <span class="text-uppercase"> ${item.vpsInstance?.rescueModeEnabling ?? '-'} </span>
                            </span>
                            <span class="detail-box">
                               Rescue Disabling : <span class="text-uppercase">${item.vpsInstance?.rescueModeDisabling ?? '-'} </span>
                            </span>
                        </div>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML("beforeend", row);
        });
    }

    function toggleDetails(index) {
        const detailsRow = document.getElementById(`details-${index}`);
        if (detailsRow.style.display === "none") {
            detailsRow.style.display = "table-row";
        } else {
            detailsRow.style.display = "none";
        }
    }

    fetchServerDetail();
</script>

@endsection