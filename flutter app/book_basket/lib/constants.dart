import 'package:flutter/material.dart';

//For TextTitle Decoration
const kTextTitle = TextStyle(
  fontSize: 25.0,
  fontWeight: FontWeight.w300,
);

//For TextField Decoration
const kTextFieldDecoration = InputDecoration(
  hintText: 'Enter a value',
  contentPadding: EdgeInsets.symmetric(vertical: 10.0, horizontal: 20.0),
  border: OutlineInputBorder(
    borderRadius: BorderRadius.all(Radius.circular(32.0)),
  ),
  enabledBorder: OutlineInputBorder(
    borderSide: BorderSide(color: Colors.redAccent, width: 1.0),
    borderRadius: BorderRadius.all(Radius.circular(32.0)),
  ),
  focusedBorder: OutlineInputBorder(
    borderSide: BorderSide(color: Colors.redAccent, width: 2.0),
    borderRadius: BorderRadius.all(Radius.circular(32.0)),
  ),
);

//For Round Border
const kRoundedBorder = RoundedRectangleBorder(
    borderRadius: BorderRadius.all(Radius.circular(20.0)));

//For heading of Container
const kContainerHeadingText = TextStyle(
  fontWeight: FontWeight.bold,
);
