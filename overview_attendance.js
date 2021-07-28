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
                document.getElementById("tableData").innerHTML = ``;
                let studentName = []
                let attendance_array = []
                console.log(dataStream)
                
                for (let i = 0; i < dataStream[1]["register"]["data"].length; i++){
                    studentName.push({i: dataStream[1]["register"]["data"][i]["name"]})
                }
                
                let data_append = `<table class="table table-striped table-responsive"><thead><tr><th scope="col">No</th><th scope="col">Name</th>`;
                
                    for (let i = 1; i <= Object.keys(dataStream).length; i++) {
                        __date = new Date(dataStream[i].time);
                        data_append = data_append + `<th scope="col">${__date.getDate()}/${__date.getMonth()+1}/${__date.getFullYear()}</th>`;
                        attendance_array.push([])
                        for (let j = 0; j < Object.keys(dataStream[i]['register']['data']).length; j++) {
                            attendance_array[i-1].push([dataStream[i]["register"]["data"][j]["is_present"]])
                        }
                    }

                    data_append = data_append + `</tr></thead><tbody>`;

                    for (let i = 0; i < studentName.length; i++) {
                        data_append = data_append + `<tr><th scope="row">${i+1}</th><th scope="row">${studentName[i]['i']}</th>`
                        for (let j = 0; j < attendance_array.length; j++ ){
                            data_append = data_append + `<td style="background-color: ${(attendance_array[j][i][0] == "false")? "#ffd2d2": "#97ffa7"}">${(attendance_array[j][i][0] == "false")? "Absent": "Present"}</td>`
                        }
                        data_append = data_append + `</tr>`
                    }

                    data_append = data_append + "</tbody></table>"
                    document.getElementById("tableData").innerHTML = data_append;
                    console.log(studentName)
                    console.log(attendance_array)
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