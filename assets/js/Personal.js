import React from "react";
import ReactDOM from "react-dom";
import { CSSTransition } from 'react-transition-group';
import ReactPaginate from 'react-paginate';

export default class Personal extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            personalInfo: {},
            page: 0,
            page_count: 0
        };
        this.setBackgroundPage = this.setBackgroundPage.bind(this);
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

        if (this._isMounted)
            this.setState({personalInfo: info, page_count: info.background.length, background: info.background[this.state.page]});
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
                    <img src={"files/images_directory/" + personalInfo.image} className="rounded-circle border bdr-three light w-100"/>
                </div>
                ) : '';
        return (
                <div id="personalDomContainer" className="bg-one container-fluid op-9 h-100">
                    <div id="personalTopRow" className="row">
                        <h2 id="resumeTitle" className="text-center col-10 offset-1 text-three font-size-5">{personalInfo.title}</h2>
                    </div>
                    <div
                        id="personalMiddleRow"
                        className="resume-identity-section row"
                        >
                        {avatar}
                        <div className="resume-identity-info col-4">
                            <h3 className="text-one vlight">{personalInfo.first_name + " " + personalInfo.last_name}</h3>
                            <div id="resumeContact">
                                <a tabIndex="0" className="btn btn-sm btn-three" role="button" data-toggle="popover" title="Contact Info" data-content={(email ? "Email: " + email : "") + (phone ? "<br />Phone: " + phone : "")} data-html="true">Contact</a>
                            </div>
                        </div>
                    </div>
                    <hr className="bdr-three light" />
                    
                    <div id="personalBottomRow" className="row">
                        <div className="resume-background col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12 text-one vlight">
                            <div className="my-auto" dangerouslySetInnerHTML={{__html: background}} />
                        </div>
                
                    </div>
                    <div id="personalPaginationRow" className="row">
                        <div className="col-6 offset-3 d-flex justify-content-center">
                            <ReactPaginate
                                previousLabel={<i class="far fa-arrow-alt-circle-left"></i>}
                                nextLabel={<i class="far fa-arrow-alt-circle-right"></i>}
                                breakLabel={'...'}
                                breakClassName={'break-me'}
                                pageCount={this.state.page_count}
                                marginPagesDisplayed={2}
                                pageRangeDisplayed={0}
                                onPageChange={this.setBackgroundPage}
                                containerClassName={'pagination'}
                                subContainerClassName={'pages pagination'}
                                activeClassName={'active'}
                                pageLinkClassName={'btn btn-outline-three'}
                                previousLinkClassName={'btn btn-outline-three'}
                                nextLinkClassName={'btn btn-outline-three'}
                                pageClassName={'mx-1'}
                                previousClassName={'mx-1'}
                                nextClassName={'mx-1'}
                                disabledLinkClassName={'disabled'}
                                activeLinkClassName={'active'}
                
                                />
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
                    <div id="personalDomWrapper" className="position-absolute content-element w-100">
                        {this.personalDom()}
                    </div>
                </CSSTransition>
                );

        return personal_dom;
    }

};
