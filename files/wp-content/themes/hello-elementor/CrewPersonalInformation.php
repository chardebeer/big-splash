<?php /* Template Name: CrewPersonalInformation */ ?>
    
<?php get_header("home"); ?>
    
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Karla:wght@200;300;500;600;700&display=swap" rel="stylesheet">

<div class="custom-form-block">
    <div class="custom-form-navigation">
        <ul>
            <li><a class="active" href="">Personal Infromation</a></li>
            <li><a href="">Personality &amp; Preferences</a></li>
            <li><a href="">Crew Review Results</a></li>
        </ul>
    </div>
    <div class="custom-form-block-data">
        <h1>Personal Information</h1>
        <p>Our Crew Profiles have been designed to cater for any and all Superyacht Crew, meaning some questions may be irrelevant to certain crew. Use your discretion when filling out the form, and only answer questions applicable to you.</p>
        <h2>The Basics</h2>
        <div class="row">
            <div class="col">
                <span class="pretty-span">First name</span>
                <input class="pretty-input" type="text">
            </div>
            <div class="col">
                <span class="pretty-span">Last name</span>
                <input class="pretty-input" type="text">
            </div>
        </div><br/>
        <span class="pretty-span">*Photo</span>
        <div class="pretty-file">
            <span>Upload photo of</span>
            <span>yourself here..</span>
        </div><br/>
        <span class="pretty-span">Current Position</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Smoking</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>No</option>
            <option>Socially</option>
        </select><br/>
        <span class="pretty-span">Vaping</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>No</option>
            <option>Socially</option>
        </select>
        <span class="pretty-span">Visible Tattoos</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>No</option>
        </select><br/>
        <span class="pretty-span">Willing to take a drug test?</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>No</option>
        </select><br/>
        <span class="pretty-span">Dietary requirements</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Vaccinated</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>Booster</option>
            <option>No</option>
        </select><br/><br/>
        <span class="pretty-span">Driving License</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Yes</option>
            <option>No</option>
        </select><br/><br/>
        <span class="pretty-span">Marital Status</span>
        <select class="pretty-select">
            <option selected disabled>Select</option>
            <option>Single</option>
            <option>In a relationship</option>
            <option>Married</option>
        </select><br/><br/>
        <span class="pretty-span" style="width: 500px;">Other personal characteristics you think may be useful for a vessel to know:</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <div class="spacer"></div><br/><br/>
        <h2>Skills and Goals</h2>
        <p>Keep written responses short and sweet. Make it easy for your reader!</p><br/>
        <span class="pretty-span">Do you have any position specific skills that you would consider yourself an expert at?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Do you have any specialized skills that may be useful to your position?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Are there any position specific jobs that you particularly enjoy doing?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Are there any position specific skills where you feel you may require a bit more training/practice?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Are there any position specific (and career specific) skills that you are particularly interested in developing/refining?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Which specific career are you looking for in your next position?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <span class="pretty-span">Do you plan to complete any courses or training in the coming year? Which ones?</span>
        <textarea class="pretty-textarea" placeholder="Write response...."></textarea><br/>
        <button class="prety-button">Save / Update</button>
        <div class="pretty-sub">Should there be any information not included in our Crew Profiles that you would like a recruiter to be aware of, please contact us to share your thoughts!</div>
    </div>
</div>

<style>
    div.custom-form-block {
        display: block;
        margin: 0 auto;
        padding: 0px;
        text-align: center;
        min-width: 860px;
    }
    div.custom-form-block > div {
        display: inline-block;
        border-top-left-radius: 32px;
        vertical-align: top;
    }

    div.custom-form-navigation {
        background-color: #F3F7F8;
        transform: translateX(4px);
        height: 4500px;
    }
    
    div.custom-form-navigation > ul {
        list-style: none;
        text-align: left;
        margin-left: -32px;
    }
    div.custom-form-navigation > ul > li {
        padding: 20px 24px;
    }
    div.custom-form-navigation > ul > li > a {
        text-decoration: none;
        color:#539B9A;
        font-size: 15px;
        font-weight: 500;
        font-family: Karla;
    }

    div.custom-form-navigation > ul > li > a.active::before {
        position: absolute;
        display: block;
        content: "";
        background-color: #539B9A;
        width: 3px;
        height: 20px;
        transform: translateX(-32px);
    }

    div.custom-form-block-data {
        text-align: left;
        width: 70%;
        background-color: #FFF;
        border-top-right-radius: 32px;
        height: 4500px;
    }
    
    div.custom-form-block-data > * {
        display: block;
        margin-left: 24px;
    }

    div.custom-form-block-data > h1 { 
        background-color: #0B2C2B;
        color:#FFF;
        line-height: 38px;
        height: 64px;
        font-size: 28px;
        text-align: left;
        vertical-align: top;
        padding: 12px 12px 12px 24px;
        margin: 0px;
        border-top-right-radius: 32px;
        font-family: Karla;
    }
    
    div.custom-form-block-data > p {
        font-size: 16px;
        padding:12px 12px 12px 12px;
        padding-left: 0px;
        color: #3F5768;
        font-weight: 500;
        font-family: Karla;
        letter-spacing: 0px;
    }

    
    div.custom-form-block-data > h2 {
        font-style: italic;
        font-weight: 300;
        font-family: Karla;
        letter-spacing: 0px;
    }

    div.row {
        display: block;
        vertical-align: top;
    }
    
    div.col {
        display: inline-block;
    }

    input.pretty-input {
        display: block;
        padding: 8px 12px;
        background-color: #E3E8EB;
        border: none;
        font-family: Karla;
        width: 250px;
    }

    span.pretty-span {
        display: block;
        font-family: Karla;
        margin-bottom: 8px;
    }

    div.pretty-file {
        background-color: #E3E8EB;
        width: 194px;
        height: 194px;
        text-align: center;
        cursor: pointer;
    }
    div.pretty-file > span {
        display: block;
        font-family: Karla;
        transform: translateY(72px);
    }
    textarea.pretty-textarea {
        background-color: #E3E8EB;
        width: 500px;
        height: 200px;
        border: none;
        resize: none;
        -webkit-text-size-adjust:none;
        -ms-text-size-adjust:none;
        -moz-text-size-adjust:none;
        text-size-adjust:none;
        padding: 8px;
    }

    select.pretty-select {
        width: 500px;
        padding: 12px;
    }

    div.spacer {
        display: block;
        width: 100%;
        height: 4px;
        background-color: #E3E8EB;
    }

    button.prety-button {
        display: block;
        padding: 12px;
        background-color: #FFFFFF;
        color:#3F5768;
        border: 1px solid #3F5768;
        border-radius: 8px;
        margin: 12px;
        margin-left: 24px;
        width: 250px;
        cursor: pointer;
        font-family: Karla;
        font-size: 16pt;
    }
    
    button.prety-button:hover {
        background-color: #3F5768;
        color:#FFFFFF;
    }

    div.pretty-sub {
        font-family: Karla;
        display: block;
        padding: 12px;
        padding-bottom: 24px;
        margin-bottom: 16px;
        color:#3F5768;
        font-size: 14px;
    }
</style>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
   $("h2:contains(Gain access to the ultimate Superyachting Recruitment Aid!)").parent().parent().parent().parent().parent().parent().hide();
   setTimeout(()=>{
         $("h2:contains(Gain access to the ultimate Superyachting Recruitment Aid!)").parent().parent().parent().parent().parent().parent().hide();
    }, 1000);
   setTimeout(()=>{
         $("h2:contains(Gain access to the ultimate Superyachting Recruitment Aid!)").parent().parent().parent().parent().parent().parent().hide();
    }, 2000);
</script>
    
<?php get_footer("contact"); ?>
    
<style>
	body {
    	margin-top: 120px !important;
        background-color:#E1EAE9 !important;
    }
    header > section.elementor-section {
        background: transparent !important;
    }
	/* Remove annoying popup
	footer > section:first-child {
    	display: none;
	} */
</style>