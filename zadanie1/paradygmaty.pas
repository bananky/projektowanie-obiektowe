program GenerateAndSortRandomNumbers;
uses SysUtils;

const
  NumberOfNumbers = 50; 

var
  Numbers: array[1..NumberOfNumbers] of Integer; 

procedure GenerateRandomNumbers;
var
  i: Integer;
begin
  Randomize; 
  for i := 1 to NumberOfNumbers do
  begin
    Numbers[i] := Random(101); 
  end;
end;

procedure SortNumbers;
var
  i, j, temp: Integer;
begin
  for i := 1 to NumberOfNumbers - 1 do
    for j := 1 to NumberOfNumbers - i do
      if Numbers[j] > Numbers[j + 1] then
      begin
        temp := Numbers[j];
        Numbers[j] := Numbers[j + 1];
        Numbers[j + 1] := temp;
      end;
end;

procedure PrintNumbers;
var
  i: Integer;
begin
  for i := 1 to NumberOfNumbers do
    WriteLn(Numbers[i]);
end;

begin
  GenerateRandomNumbers;
  SortNumbers; 
  PrintNumbers; 
end.
