<div class="card-outer-container">
    <div class="card-container">
        <span class="edit-symbol"><i class="fas fa-edit"></i></span>
        <h2><?php echo $user['name'] ?></h2>
        <h4><?php echo $user['email'] ?></h4>
        <p><?php echo 'Какая нибудь инфа'; ?></p>

        <div class="imp-data">
            <p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class = "icon-style"><path d="M0 96l576 0c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96zm0 32V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128H0zM64 405.3c0-29.5 23.9-53.3 53.3-53.3H234.7c29.5 0 53.3 23.9 53.3 53.3c0 5.9-4.8 10.7-10.7 10.7H74.7c-5.9 0-10.7-4.8-10.7-10.7zM176 192a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm176 16c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16z"/></svg>
                1122 3344 5566</p>
            <p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class = "icon-style"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>9876543211</p>
        </div>
    </div>
</div>


<style>

    .card-outer-container {
        background-color: #e0f2f1;
        font-family: Montserrat, sans-serif;

        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;

        min-height: 100vh;
        margin: 0;

    }


    p {
        font-size: 18px;
        line-height: 21px;
    }

    .card-container {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0px 10px 20px -10px rgba(0,0,0,0.75);
        /* 	color: #B3B8CD; */
        padding-top: 30px;
        position: relative;
        width: 350px;
        max-width: 100%;
        text-align: center;
    }

    .edit-symbol {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .imp-data {
        background-color: #26a69a;
        text-align: left;
        padding: 30px;
        margin-top: 30px;
        border-radius: 5px;
    }


    .imp-data p {
        border: 1px solid #2D2747;
        border-radius: 5px;
        display: block;
        /* 	text-align: center; */
        font-size: 20px;
        margin: 10px 7px 7px 10;
        padding: 20px;
    }

    .icon-style {
        height: 20px;
        margin-right: 10px;
    }

</style>