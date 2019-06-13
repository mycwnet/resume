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

    var current_color = $('#profile_configuration_color').val();
    console.log("COLOR: " + current_color);
    var current_palette = createColorPalette(current_color);
    $('#colorPalette').html(current_palette);

    $('#profile_configuration_color').on('change', function (e) {
        var color = $(e.target).val();
        var palette = createColorPalette(color);
        $('#colorPalette').html(palette);
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
    console.log("ADD COL Index: " + index);
    proficiencyCollection.data('index', index + 1);

    var proficiencyCard = $('<div class="card my-2"><div class="card-header"></div></div>');
    var proficiency = $('<div class="card-body"></div>').append(proficiencyForm);

    proficiencyCard.append(proficiency);
    addDeleteProficiencyButton(proficiencyCard, index + 1);

    addProficiencyButton.before(proficiencyCard);
    proficiencyIcons(proficiencyCard, index);
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
    console.log("ICONS INDEX: " + prof_index);
    var icons_container = proficiency.find('.proficiency-icon-list');
    var hidden_icon_value = proficiency.find('.hidden-icon-value');
    proficiency.find('.proficiency-title').change(function (e) {
        var prof_title = $(e.target).val();
        console.log(prof_title);
        icons_container.html('<div class="text-center"><i class="fas fa-spinner fa-3x fa-pulse"></i></div>');

        $.ajax({

            url: '/brandicons/' + prof_title,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var choices = $('<div id="modifiedChoices"><div class="row mx-0">' +
                        '<span class="align-middle my-auto"> <div class="form-check">' +
                        '<input type="radio" id="profile_proficiencies_' + prof_index + '_icon_placeholder" name="profile[proficiencies][' + prof_index + '][icon]" class="form-check-input" value="" checked="checked">' +
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
        proficiency.on('click', '.form-check-input', function (e) {
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

function createColorPalette(color) {
    var color_array = hexToAnologuousArray(color);
    var palette = $("<ul id='colorList'></ul>");
    $.each(color_array, function (index, value) {
        //  var invert_color=hexShiftHueByDegree(value, 180);
        var color_item = $("<li class='color_item' style='background: " + value + "'><span class='color_label' style='color: " + value + "; -webkit-filter: invert(100%); filter: invert(100%);'>" + value + "</span></li>");
        palette.append(color_item);
    });

    return palette;
}

function hexToAnologuousArray(hex) {
    var hex_array = [];


    var shifted_hue = hex;

    for (var i = 0; i < 6; i++) {
        shifted_hue = hexShiftHueByDegree(hex, 20 * i);
        hex_array.push(shifted_hue);
    }
    console.log("Hex Array: " + JSON.stringify(hex_array));
    return hex_array;
}

/*
 * Modified verson of hexToComplimentary by 
 * Edd https://stackoverflow.com/users/4939630/edd
 */
function hexShiftHueByDegree(hex, degree) {

    // Convert hex to rgb
    // Credit to Denis http://stackoverflow.com/a/36253499/4939630
    var rgb = 'rgb(' + (hex = hex.replace('#', '')).match(new RegExp('(.{' + hex.length / 3 + '})', 'g')).map(function (l) {
        return parseInt(hex.length % 2 ? l + l : l, 16);
    }).join(',') + ')';

    // Get array of RGB values
    rgb = rgb.replace(/[^\d,]/g, '').split(',');

    var r = rgb[0], g = rgb[1], b = rgb[2];

    // Convert RGB to HSL
    // Adapted from answer by 0x000f http://stackoverflow.com/a/34946092/4939630
    r /= 255.0;
    g /= 255.0;
    b /= 255.0;
    var max = Math.max(r, g, b);
    var min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2.0;

    if (max === min) {
        h = s = 0;  //achromatic
    } else {
        var d = max - min;
        s = (l > 0.5 ? d / (2.0 - max - min) : d / (max + min));

        if (max === r && g >= b) {
            h = 1.0472 * (g - b) / d;
        } else if (max === r && g < b) {
            h = 1.0472 * (g - b) / d + 6.2832;
        } else if (max === g) {
            h = 1.0472 * (b - r) / d + 2.0944;
        } else if (max === b) {
            h = 1.0472 * (r - g) / d + 4.1888;
        }
    }

    h = h / 6.2832 * 360.0 + 0;

    // Shift hue x degrees
    h += degree;
    if (h > 360) {
        h -= 360;
    }
    h /= 360;

    // Convert h s and l values into r g and b values
    // Adapted from answer by Mohsen http://stackoverflow.com/a/9493060/4939630
    if (s === 0) {
        r = g = b = l; // achromatic
    } else {
        var hue2rgb = function hue2rgb(p, q, t) {
            if (t < 0)
                t += 1;
            if (t > 1)
                t -= 1;
            if (t < 1 / 6)
                return p + (q - p) * 6 * t;
            if (t < 1 / 2)
                return q;
            if (t < 2 / 3)
                return p + (q - p) * (2 / 3 - t) * 6;
            return p;
        };

        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        var p = 2 * l - q;

        r = hue2rgb(p, q, h + 1 / 3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1 / 3);
    }

    r = Math.round(r * 255);
    g = Math.round(g * 255);
    b = Math.round(b * 255);

    // Convert r b and g values to hex
    rgb = b | (g << 8) | (r << 16);

    return "#" + (0x1000000 | rgb).toString(16).substring(1);
}  