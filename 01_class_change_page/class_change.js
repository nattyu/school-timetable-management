function PageSwitch (e) {
    let selected_id = e.id;

    let give_btn = document.getElementById("give");
    let trade_btn = document.getElementById("trade");
    let self_study_btn = document.getElementById("self-study");

    let give_page = document.getElementById("container-give");
    let trade_page = document.getElementById("container-trade");
    let self_study_page = document.getElementById("container-self-study");

    if (selected_id === "give") {
        give_btn.className = "selected_tab";
        trade_btn.className = "";
        self_study_btn.className = "";

        give_page.className = "block";
        trade_page.className = "none";
        self_study_page.className = "none";
    } else if (selected_id === "trade") {
        give_btn.className = "";
        trade_btn.className = "selected_tab";
        self_study_btn.className = "";

        give_page.className = "none";
        trade_page.className = "block";
        self_study_page.className = "none";
    } else if (selected_id === "self-study") {
        give_btn.className = "";
        trade_btn.className = "";
        self_study_btn.className = "selected_tab";

        give_page.className = "none";
        trade_page.className = "none";
        self_study_page.className = "block";
    }
}