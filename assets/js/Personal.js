import React from "react";
import ReactDOM from "react-dom";
import { CSSTransition } from 'react-transition-group';
import ReactPaginate from 'react-paginate';

var $ = require('jquery');

export default class Personal extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            personalInfo: {},
            page: 0,
            page_count: 0,
            encrypted: true
        };
        this.CryptoJS = require("crypto-js");
        this.setBackgroundPage = this.setBackgroundPage.bind(this);
        this.decryptContact = this.decryptContact.bind(this);
        this.encryptContact = this.encryptContact.bind(this);
    }

    componentDidMount() {
        this._isMounted = true;
        this.setPersonalInfo(this.props.personal_info);
        var self = this;
        $('#showContact').on('show.bs.popover', function () {
            self.decryptContact();
        });
        $('#showContact').on('hidden.bs.popover', function () {
            self.encryptContact();
        }); 

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

    encryptContact(personal_info=null) {
        var info =personal_info?personal_info: this.state.personalInfo;
        var encrypted = this.state.encrypted;
        if (this._isMounted && !encrypted) {
            info.phone = this.CryptoJS.AES.encrypt(info.phone, 'cwnet r3$um3').toString();
            info.email = this.CryptoJS.AES.encrypt(info.email, 'cwnet r3$um3').toString();
            this.setState({personalInfo: info, encrypted:true});
        }
    }

    decryptContact() {
        var info = this.state.personalInfo;
        var encrypted = this.state.encrypted;
        if (this._isMounted && encrypted) {

            var phonebytes = this.CryptoJS.AES.decrypt(info.phone, 'cwnet r3$um3');
            info.phone = phonebytes.toString(this.CryptoJS.enc.Utf8);
            var emailbytes = this.CryptoJS.AES.decrypt(info.email, 'cwnet r3$um3');
            info.email = emailbytes.toString(this.CryptoJS.enc.Utf8);
            this.setState({personalInfo: info, encrypted:false});
        }
    }

    setBackgroundPage(data) {
        if (this._isMounted)
            this.setState({page: data.selected, background: this.state.personalInfo.background[data.selected]});

    }

    componentWillUnmount() {
        this._isMounted = false;
    }

    personalDom() {
        var personalInfo = this.state.personalInfo;
        var background = this.state.background;
        var phone = personalInfo.phone;
        var email = personalInfo.email;
        var avatar = personalInfo.image ? (
                <div id="resumeAvatar" className="col-lg-2 col-md-3 col-4 offset-2">
                    <img src={"files/images_directory/" + personalInfo.image} className="rounded-circle border bdr-one dark w-100"/>
                </div>
                ) : '';
        var pagination=this.state.page_count >1?(<ReactPaginate
                                previousLabel={ < i class = "far fa-arrow-alt-circle-left" > </i>}
                                nextLabel={ < i class = "far fa-arrow-alt-circle-right" > </i>}
                                breakLabel={'...'}
                                breakLinkClassName={'break-me link link-one dark'}
                                pageCount={this.state.page_count}
                                marginPagesDisplayed={1}
                                pageRangeDisplayed={1}
                                onPageChange={this.setBackgroundPage}
                                containerClassName={'pagination'}
                                subContainerClassName={'pages pagination'}
                                activeClassName={'active'}
                                pageLinkClassName={'btn btn-outline-one dark'}
                                previousLinkClassName={'btn btn-outline-one dark'}
                                nextLinkClassName={'btn btn-outline-one dark'}
                                pageClassName={'mx-1'}
                                previousClassName={'mx-1'}
                                nextClassName={'mx-1'}
                                disabledLinkClassName={'disabled'}
                                activeLinkClassName={'active'}
                
                                />):"";
        return (
                <div id="personalDomContainer" className="container-fluid  pb-5">
                    <div id="personalTopRow" className="row">
                        <h2 id="resumeTitle" className="section-title text-center col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-one dark">{personalInfo.title}</h2>
                    </div>
                    <div
                        id="personalMiddleRow"
                        className="resume-identity-section row"
                        >
                        {avatar}
                        <div className="resume-identity-info col-lg-4 col-md-4 col-6">
                            <h3 className="resume-name text-one vlight">{personalInfo.first_name + " " + personalInfo.last_name}</h3>
                            <div id="resumeContact">
                                <a tabIndex="0" id="showContact" className="btn btn-sm btn-one dark" role="button" data-toggle="popover" title="Contact Info" data-content={(email ? "Email: " + email : "") + (phone ? "<br />Phone: " + phone : "")} data-html="true">Contact</a>
                            </div>
                        </div>
                    </div>
                    <hr className="bdr-one dark" />
                
                    <div id="personalBottomRow" className="row">
                        <div className="resume-background col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-one vlight">
                            <div className="my-auto" dangerouslySetInnerHTML={{__html: background}} />
                        </div>
                
                    </div>
                    <div id="personalPaginationRow" className="row">
                        <div className="col-6 offset-3 d-flex justify-content-center">
                        
                            {pagination}
                        </div>
                    </div>
                </div>);

    }

    render() {
        var personal_dom = (
                <CSSTransition
                    in={true}
                    appear={true}
                    timeout={1000}
                    classNames="fade"
                    >
                    <div id="personalDomWrapper" className="position-absolute content-element w-100 bg-one op-9">
                        {this.personalDom()}
                    </div>
                </CSSTransition>
                );

        return personal_dom;
    }

};
