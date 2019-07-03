import React from "react";
import ReactDOM from "react-dom";
import { CSSTransition } from 'react-transition-group';
import ReactPaginate from 'react-paginate';

var $ = require('jquery');

export default class Contact extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            personalInfo: {},
            contactEncrypted: props.encrypted,
            phone: "",
            email: "",

        };
        this.CryptoJS = require("crypto-js");
        this.decryptContact = this.decryptContact.bind(this);
        this.encryptContact = this.encryptContact.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;
        this.setPersonalInfo(this.props.personal_info);

    }

    componentDidUpdate(prevProps) {
        this._isMounted = true;
        var curProps = this.props;
        var curInfo = curProps.personal_info;
        var prevInfo = prevProps.personal_info;
        if (curInfo !== prevInfo) {
            this.setPersonalInfo(curInfo);
        }
    }

    setPersonalInfo(info) {
        if (this._isMounted) {
            this.setState({personalInfo: info, page_count: info.background.length, background: info.background[this.state.page]});
        }
    }

    getPersonalContacts() {
        var phone = this.state.contactEncrypted === true ? "" : this.state.phone;
        var email = this.state.contactEncrypted === true ? "" : this.state.email;
        var personal_contact_exists = this.state.personalInfo.phone || this.state.personalInfo.email ? true : false;
        var phone_elements = phone ? <div id="contactPhone" class="text-five light"><span class="fas fa-mobile-alt contact-icon"></span><span class="contact-value align-top px-2">{phone}</span></div> : "";
        var email_elements = email ? <div id="contactEmail" class="text-five light"><span class="far fa-envelope contact-icon"></span><span class="contact-value align-top px-2">{email}</span></div> : "";
        var contact_elements = this.state.contactEncrypted === true ? (
                <a tabIndex="0" id="showContact" className="btn btn-sm btn-five dark" role="button" title="Show Contact Info" 
                   onClick={() => {
                           this.decryptContact()
                       }}>Show Phone and Email</a>) : (<div id="contactInfo">
                        {phone_elements}
                        {email_elements}
                    </div>);
        var personal_contacts = personal_contact_exists ? (<div id="personalContactElements" className="contacts-segment">                            
            <h3 className="contact-section-label text-five dark">Personal</h3>
            {contact_elements}</div>) : "";

        return personal_contacts;
    }

    getOnlineContacts() {
        var linkedin = this.state.personalInfo.linkedin;
        var github = this.state.personalInfo.github;
        var gitlab = this.state.personalInfo.gitlab;
        var online_contact_exists = linkedin || github || gitlab ? true : false;
        var linkedin_elements = linkedin ? <div id="contactLinkedin" class="text-five light"><span class="fab fa-linkedin contact-icon"></span><a href={linkedin} className="contact-link align-top px-2" target="_blank">{this.cleanUrl(linkedin)}</a></div> : "";
        var github_elements = github ? <div id="contactGithub" class="text-five light"><span class="fab fa-github contact-icon"></span><a href={github} className="contact-link align-top px-2" target="_blank">{this.cleanUrl(github)}</a></div> : "";
        var gitlab_elements = gitlab ? <div id="contactGitlab" class="text-five light"><span class="fab fa-gitlab contact-icon"></span><a href={gitlab} className="contact-link align-top px-2" target="_blank">{this.cleanUrl(gitlab)}</a></div> : "";

        var online_contacts = online_contact_exists ? (<div id="onlineContactElements" className="contacts-segment">                            
    <h3 className="contact-section-label text-five dark">Online</h3>
    {linkedin_elements}
    {github_elements}
    {gitlab_elements}
</div>) : "";

        return online_contacts;
    }
    
    cleanUrl(url){
        console.log("url: " + url);
        var clean_url=url?url.replace(/^(?:https?:\/\/)?(?:www\.)?/i, ""):"";
        return clean_url;
    }

    encryptContact(personal_info = null) {
        var info = personal_info ? personal_info : this.state.personalInfo;
        var encrypted = this.state.contactEncrypted;
        if (this._isMounted && !encrypted) {
            console.log("pre enc phone: " + info.phone + " pre enc email: " + info.email);
            var phone = this.CryptoJS.AES.encrypt(info.phone, 'cwnet r3$um3').toString();
            var email = this.CryptoJS.AES.encrypt(info.email, 'cwnet r3$um3').toString();
            console.log("enc phone: " + info.phone + " enc email: " + info.email);
            this.setState({email: email, phone: phone, contactEncrypted: true});
    }
    }

    decryptContact() {
        var info = this.state.personalInfo;
        var encrypted = this.state.contactEncrypted;
        if (this._isMounted && encrypted) {
            console.log("pre dec phone: " + info.phone + " pre dec email: " + info.email);
            var phonebytes = this.CryptoJS.AES.decrypt(info.phone, 'cwnet r3$um3');
            var phone = phonebytes.toString(this.CryptoJS.enc.Utf8);
            var emailbytes = this.CryptoJS.AES.decrypt(info.email, 'cwnet r3$um3');
            var email = emailbytes.toString(this.CryptoJS.enc.Utf8);
            console.log("dec phone: " + info.phone + " dec email: " + info.email);
            this.setState({email: email, phone: phone, contactEncrypted: false});
        }
    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    contactDom() {
        var personalInfo = this.state.personalInfo;

        var avatar = personalInfo.image ? (
                <div id="resumeAvatar" className="col-lg-2 col-md-3 col-4 offset-2 text-center">
                    <img src={"files/images_directory/" + personalInfo.image} className="rounded-circle border bdr-one dark w-50 align-middle"/>
                </div>
                ) : '';

        return (
                <div id="contactDomContainer" className="container-fluid  pb-5">
                    <div id="contactTopRow" className="row">
                        <h2 id="contactTitle" className="section-title text-center col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-five dark">Contact</h2>
                    </div>
                    <div
                        id="contactMiddleRow"
                        className="contact-identity-section row"
                        >
                        {avatar}
                        <div className="contact-identity-info col-lg-8 col-md-7 col-6">
                            <h3 className="contact-name text-five light align-middle">{personalInfo.first_name + " " + personalInfo.last_name}</h3>
                        </div>
                
                    </div>
                    <div id="contactBottomRow" className="row">
                
                        <div id="contactDisplay" className="col-lg-8 col-md-8 col-sm-9 col-11 offset-lg-4 offset-md-4 offset-sm-3 offset-1">
                            {this.getPersonalContacts()}
                            {this.getOnlineContacts()}
                        </div>
                    </div>
                </div>);

    }

    render() {
        var contact_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="condactDomWrapper" className="position-absolute content-element w-100 bg-five op-9">
                        {this.contactDom()}
                    </div>
                </CSSTransition>
                );

        return contact_dom;
    }

};
