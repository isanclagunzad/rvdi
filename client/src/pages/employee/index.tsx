import { EmployeeStyled } from "./style";
import AdvanceSearch from "../../components/advance-search";

function Employee() {
  return (
    <EmployeeStyled>
      <AdvanceSearch printEndpoint="/printEmployee" />
    </EmployeeStyled>
  );
}

export default Employee;
