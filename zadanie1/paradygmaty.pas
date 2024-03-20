program GenerateRandomNumbers;
uses SysUtils;

procedure GenerateAndPrintRandomNumbers;
var
  i, number: Integer;
begin
  Randomize; 
  for i := 1 to 50 do
  begin
    number := Random(101); 
    WriteLn(number);
  end;
end;

begin
  GenerateAndPrintRandomNumbers;
end.
