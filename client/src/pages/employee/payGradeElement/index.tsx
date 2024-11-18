import { accessWindowVar } from "src/services/parseVar";
import { SyntheticEvent, useEffect, useMemo, useState } from "react";
import ucfirst from "ucfirst";
import { PayGradeObject } from "./type";

const PayGradeElement = () => {
  const payGradeList: { [key: string]: number } =
    accessWindowVar("payGradeList");
  const payGradeObject: PayGradeObject = accessWindowVar("payGradeObject");

  const payGradeSelected = useMemo(() => {
    return payGradeObject.pay_grade_type_id * 1;
  }, [payGradeObject]);

  const [selectedValue, setSelectedValue] = useState(payGradeSelected);

  useEffect(() => {
    console.log({ payGradeSelected, payGradeList });
  }, [payGradeSelected]);

  const handleChange = (
    event: React.ChangeEvent<HTMLSelectElement>,
    ...arg: any
  ) => {
    //console.log(event.target.value, arg);
    setSelectedValue(parseInt(event.target.value));
  };

  return (
    <div className="form-group">
      <label>
        Pay Grade<span className="validateRq">*</span>
      </label>
      <select
        name="pay_grade_type_id"
        className="form-control pay_grade_id required"
        defaultValue={payGradeSelected}
        onChange={handleChange}
        value={selectedValue}
      >
        {Object.entries(payGradeList).map(([payGradeValue, payGradeKey]) => {
          return <option value={payGradeKey}>{ucfirst(payGradeValue)}</option>;
        })}
      </select>
      <input
        type="hidden"
        name="pay_grade_id"
        value={payGradeObject.pay_grade_id}
      />
    </div>
  );
};

export default PayGradeElement;
