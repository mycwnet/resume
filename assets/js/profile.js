import React from 'react';

var $ = require('jquery');
require('bootstrap');


var projectHistoryCollection;
var proficiencyCollection;
var samplesCollection;
var addProjectHistoryButton = $('<button type="button" class="btn btn-secondary my-2 add-project-history">Add Project</button>');
var addProficiencyButton = $('<button type="button" class="btn btn-secondary my-2 add-proficiency">Add Proficiency</button>');
var addSampleButton = $('<button type="button" class="btn btn-secondary my-2 add-sample">Add Sample</button>');
$(document).ready(function () {
    projectHistoryCollection = $('#historiesCollapse');
    proficiencyCollection = $("#proficienciesCollapse");
    samplesCollection = $("#samplesCollapse");

    //set index value for project history collections
    projectHistoryCollection.data('index', projectHistoryCollection.find('.card').length);
    var histindex = 0;
    projectHistoryCollection.find('.card').each(function () {
        histindex = histindex + 1;
        addDeleteHistoryButton($(this), histindex);
    });
    projectHistoryCollection.append(addProjectHistoryButton);

    addProjectHistoryButton.click(function (e) {
        e.preventDefault();
        addProjectHistoryCollection();
    });

    //set index value for proficiencies collections
    proficiencyCollection.data('index', proficiencyCollection.find('.card').length);
    var profindex = 0;
    proficiencyCollection.find('.card').each(function () {
        proficiencyIcons($(this), profindex);
        profindex = profindex + 1;
        addDeleteProficiencyButton($(this), profindex);
    });
    proficiencyCollection.append(addProficiencyButton);

    addProficiencyButton.click(function (e) {
        e.preventDefault();
        addProficiencyCollection();
    });
    //set index value for samples collections
    samplesCollection.data('index', samplesCollection.find('.card').length);
    var sampindex = 0;
    samplesCollection.find('.card').each(function () {
        sampindex = sampindex + 1;
        addDeleteSampleButton($(this), sampindex);
    });
    samplesCollection.append(addSampleButton);

    addSampleButton.click(function (e) {
        e.preventDefault();
        addSampleCollection();
    });
    $('#projectSamplesList').on('change', '.custom-file-input', function (e) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
        console.log('file: ' + e.target.files[0].name);
    });
});

function addProjectHistoryCollection() {
    var prototype = projectHistoryCollection.data('prototype');
    var index = projectHistoryCollection.data('index');
    var projectForm = prototype.replace(/__name__/g, index);

    projectHistoryCollection.data('index', index + 1);

    var projectHistoryCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var project = $('<div class="card-body"></div>').append(projectForm);

    projectHistoryCard.append(project);
    addDeleteHistoryButton(projectHistoryCard, index + 1);

    addProjectHistoryButton.before(projectHistoryCard);
}

function addDeleteHistoryButton(project, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProjectHistoryButton = $('<button type="button" class="btn btn-warning my-2 del-project-history">Remove Project</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProjectHistoryButton);
        deleteProjectHistoryButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        project.append(cardfooter);
    }

}

function addProficiencyCollection() {
    var prototype = proficiencyCollection.data('prototype');
    var index = proficiencyCollection.data('index');
    var proficiencyForm = prototype.replace(/__name__/g, index);

    proficiencyCollection.data('index', index + 1);

    var proficiencyCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var proficiency = $('<div class="card-body"></div>').append(proficiencyForm);

    proficiencyCard.append(proficiency);
    addDeleteProficiencyButton(proficiencyCard, index + 1);

    addProficiencyButton.before(proficiencyCard);
}

function addDeleteProficiencyButton(proficiency, index) {

    //console.log(index);
    if (index > 1) {
        var deleteProficiencyButton = $('<button type="button" class="btn btn-warning my-2 del-proficiency">Remove Proficiency</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteProficiencyButton);
        deleteProficiencyButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        proficiency.append(cardfooter);
    }

}

function proficiencyIcons(proficiency, prof_index) {

    var icons_container = proficiency.find('.proficiency-icon-list');
    var hidden_icon_value = proficiency.find('.hidden-icon-value');
    proficiency.find('.proficiency-title').change(function (e) {
        var prof_title = $(e.target).val();
        icons_container.html('<div class="text-center"><i class="fas fa-spinner fa-3x fa-pulse"></i></div>');

        $.ajax({

            url: '/brandicons/' + prof_title,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var choices = $('<div id="modifiedChoices"><div class="row mx-0">' +
                        '<span class="align-middle my-auto"> <div class="form-check">' +
                        '<input type="radio" id="profile_proficiencies_' + prof_index + '_icon_placeholder" name="profile[proficiencies][' + prof_index +'][icon]" class="form-check-input" value="" checked="checked">' +
                        '<label class="form-check-label" for="profile_proficiencies_' + prof_index + '_icon_placeholder"> </label></div></span>' +
                        '<span class="align-middle my-auto">' +
                        '<label for="profile_proficiencies_' + prof_index + '_icon_placeholder" class="form-check-label icon_select_label">None</label>' +
                        '</span>' +
                        '</div></div>');
                var count = 0;
                $.each(data, function (index, value) {
                    choices.append('<div class="row mx-0">' +
                            '<span class="align-middle my-auto"> <div class="form-check">' +
                            '<input type="radio" id="profile_proficiencies_' + prof_index + '_icon_' + count + '" name="profile[proficiencies][' + prof_index + '][icon]" class="form-check-input" value="' + index + '">' +
                            '<label class="form-check-label" for="profile_proficiencies_' + prof_index + '_icon_' + count + '"> </label></div></span>' +
                            '<span class="align-middle my-auto">' +
                            '<label for="profile_proficiencies_' + prof_index + '_icon_' + count + '" class="form-check-label icon_select_label">' +
                            '<i class="fab fa-' + value + ' fa-3x"></i>' +
                            '</label>' +
                            '</span></div>'
                            );
                    
                });
                icons_container.html(choices);
            },
            error: function (request, error)
            {
                console.log("Request: " + JSON.stringify(request));
            }
        });
        proficiency.on('click','.form-check-input',function (e) {
            var icon_name = $(e.target).val();
            hidden_icon_value.val(icon_name);
        });
                
    });

}

function addSampleCollection() {
    var prototype = samplesCollection.data('prototype');
    var index = samplesCollection.data('index');
    var sampleForm = prototype.replace(/__name__/g, index);

    samplesCollection.data('index', index + 1);

    var sampleCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var sample = $('<div class="card-body"></div>').append(sampleForm);

    sampleCard.append(sample);
    addDeleteSampleButton(sampleCard, index + 1);

    addSampleButton.before(sampleCard);
}

function addDeleteSampleButton(sample, index) {

    //console.log(index);
    if (index > 1) {
        var deleteSampleButton = $('<button type="button" class="btn btn-warning my-2 del-sample">Remove Sample</button>');

        var cardfooter = $('<div class="card-footer"></div>').append(deleteSampleButton);
        deleteSampleButton.click(function (e) {
            e.preventDefault();
            $(e.target).parents('.card').remove();
        });

        sample.append(cardfooter);
    }

}