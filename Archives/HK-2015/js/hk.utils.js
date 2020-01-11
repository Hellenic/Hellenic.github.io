"use strict";
/**
 * Checks if string is empty or null.
 */
String.prototype.isEmpty = function()
{
	if (this == null || this.length <= 0)
		return true;

	return false;
};

/**
 * Checks if this string contains the given string.
 *
 */
String.prototype.contains = function(value)
{
	if (this.isEmpty() || typeof(value) !== "string")
		return false;

	if (this.indexOf(value) >= 0)
		return true;

	return false;
};

function getFirstSentence(text)
{
	var paragraph = getFirstParagraph(text);
	var sentence = paragraph.substring(0, paragraph.indexOf(".")+1);
	sentence += "..";
	return sentence;
}

function getFirstParagraph(text)
{
	var contents = $(text).contents();
	if (contents.length > 0)
	{
		var textContent = contents.filter(function(element) {
			// Filter by nodeType == "text"
			return (this.nodeType == 3);
		});
		return textContent.first().get(0).textContent;
	}
}

function formatDate(dateString)
{
	var d = new Date(dateString);
	var date = d.getDate();
	var month = d.getMonth() + 1;
	var year = d.getFullYear();

	return date +"."+ month +"."+ year;
}
