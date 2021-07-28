let dataStream;
const search_class = () => {
    let sub;

    for (let i = 0; i < document.getElementsByClassName("subject").length; i++) {
        if (document.getElementsByClassName("subject")[i].checked == true) {
            sub = document.getElementsByClassName("subject")[i].value;
        }
    }

    let __class;

    for (let i = 0; i < document.getElementsByClassName("search_class").length; i++) {
        if (document.getElementsByClassName("search_class")[i].checked == true) {
            __class = document.getElementsByClassName("search_class")[i].value;
        }
    }

    const data = {
        'class': __class,
        'subject': sub
    }

    if (__class == undefined || sub == undefined) {
        notie.alert({
            type: 2, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
            text: "Provide a subject and a class",
        });
    } else {
        $.post("./api.php?funct=get", data)
            .done((data) => {
                notie.alert({
                    type: 1, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                    text: "Request Processed",
                })
                if (data == "No Data") {
                    notie.alert({
                        type: 4, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                        text: "No Register Data Found",
                    });
                    document.getElementById("tableData").innerHTML = `<tr class="table-danger">
                <th scope="row" colspan="4">
                    <center>No Data Found</center>
                </th>
                </tr>`;
                } else {
                    const data_parse = dataStream = JSON.parse(data);
                    console.log(data_parse);
                    document.getElementById("tableData").innerHTML = ``;

                    for (let i = 1; i <= Object.keys(dataStream).length; i++) {
                        const date = new Date(dataStream[i].time);
                        let data_got = "";

                        for (let j = 0; j < Object.keys(dataStream[i]['register']['data']).length; j++) {
                            data_got = data_got + `
                        <tr class="${(dataStream[i]['register']['data'][j]['is_present'] != 'false')? 'table-success': 'table-danger'}">
                                <th scope="row">${j+1}</th>
                                <th scope="row">${dataStream[i]['register']['data'][j]['name']}</th>
                                <th scope="row">${(dataStream[i]['register']['data'][j]['is_present'] == 'false')? 'Absent': 'Present'}</th>
                            </tr>
                        `;
                        }

                        $("#tableData").append(`<br>
                    <h1 class="display-6"><center>${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}<br>${(date.getHours()%12 == 0)? 12 : date.getHours()%12}:${date.getMinutes()} ${(date.getHours() <= 12)? 'AM' : 'PM'}<br></center></h1>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="internalData">
                        ${data_got}
                    </tbody>
                </table>
                    `)
                    }
                }
            })
            .fail(() => {
                notie.alert({
                    type: 3, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                    text: "Unable to process specified request",
                });
            });
    }
}


const send_check = (classname, time, subject) => {

    const data = {
        'class': classname,
        'subject': subject,
        'time': time
    }
    $.post("./api.php?funct=get_date", data)
        .done((data) => {
            notie.alert({
                type: 1, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                text: "Request Processed",
            })
            if (data == "No Data") {
                notie.alert({
                    type: 4, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                    text: "No Register Data Found",
                });
                document.getElementById("tableData").innerHTML = `<tr class="table-danger">
                <th scope="row" colspan="4">
                    <center>No Data Found</center>
                </th>
                </tr>`;
            } else {
                const data_parse = dataStream = JSON.parse(data);
                console.log(data_parse);
                document.getElementById("tableData").innerHTML = ``;

                for (let i = 1; i <= Object.keys(dataStream).length; i++) {
                    const date = new Date(dataStream[i].time);
                    let data_got = "";

                    for (let j = 0; j < Object.keys(dataStream[i]['register']['data']).length; j++) {
                        data_got = data_got + `
                        <tr class="${(dataStream[i]['register']['data'][j]['is_present'] != 'false')? 'table-success': 'table-danger'}">
                                <th scope="row">${j+1}</th>
                                <th scope="row">${dataStream[i]['register']['data'][j]['name']}</th>
                                <th scope="row">${(dataStream[i]['register']['data'][j]['is_present'] == 'false')? 'Absent': 'Present'}</th>
                            </tr>
                        `;
                    }

                    $("#tableData").append(`<br>
                    <h1 class="display-6"><center>${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}<br>${(date.getHours()%12 == 0)? 12 : date.getHours()%12}:${date.getMinutes()} ${(date.getHours() <= 12)? 'AM' : 'PM'}<br></center></h1>
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="internalData">
                        ${data_got}
                    </tbody>
                </table>
                    `)
                }
            }
        })
        .fail(() => {
            notie.alert({
                type: 3, // optional, default = 4, enum: [1, 2, 3, 4, 5, 'success', 'warning', 'error', 'info', 'neutral']
                text: "Unable to process specified request",
            })
        })
}