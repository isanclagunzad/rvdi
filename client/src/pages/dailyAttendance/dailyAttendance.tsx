import AdvanceSearch from "../../components/advance-search";
import { Col } from "antd";
import { DatePicker } from "antd";
import React, { SyntheticEvent, useEffect, useState } from "react";
import { useUrlParams } from "../../services/useUrlParams";
import { END_DATE, START_DATE } from "./type";
import dayjs, { Dayjs } from "dayjs";
import zeropad from "zeropad";
import RenderRootById from "src/services/root";
import DailyAttendanceTable from "src/pages/dailyAttendance/dailyAttendanceTable";

const { RangePicker } = DatePicker;
const DATE_FORMAT = "DD/MM/YYYY";

function DailyAttendance() {
  const year = new Date().getFullYear();
  const month = zeropad(new Date().getMonth() + 1, 2);

  const defaultDates = {
    start: dayjs(`${year}-${month}-01`),
    end: dayjs(`${year}-${month}-31`),
  };
  const [startDate, setStartDate] = useState(
    defaultDates.start.format(DATE_FORMAT),
  );
  const [endDate, setEndDate] = useState(defaultDates.end.format(DATE_FORMAT));
  const [date, setDate] = useState<any>(undefined);
  const urlParams = useUrlParams();

  useEffect(() => {
    setStartDate(
      (
        ((date && date.length && date[0]) || defaultDates.start) as Dayjs
      ).format(DATE_FORMAT),
    );
    setEndDate(
      (((date && date.length && date[1]) || defaultDates.end) as Dayjs).format(
        DATE_FORMAT,
      ),
    );
  }, [date]);

  useEffect(() => {
    setDate([
      dayjs(urlParams[START_DATE] || defaultDates.start, DATE_FORMAT),
      dayjs(urlParams[END_DATE] || defaultDates.end, DATE_FORMAT),
    ]);
  }, [urlParams]);

  const handleChange = (event: any) => {
    if (event.target.value === "") {
      setStartDate("");
      setEndDate("");
      setDate([]);
    }
  };

  useEffect(() => {
    RenderRootById(<DailyAttendanceTable />, "react-daily-attendance-table");
  }, []);

  return (
    <>
      <AdvanceSearch
        submitPath="/dailyAttendance"
        formId="dailyAttendanceReport"
        prependElements={({ searchCriteriaState }) => {
          const [searchCriteria, setSearchCriteria] = searchCriteriaState;
          return (
            <>
              <Col span={12}>
                <input
                  type="hidden"
                  name={START_DATE}
                  value={startDate}
                  onClick={handleChange}
                />
                <input
                  type="hidden"
                  name={END_DATE}
                  value={endDate}
                  onClick={handleChange}
                />
                <RangePicker
                  onChange={(dates: any[] | null) => {
                    setDate(dates);
                    if (dates && dates.length) {
                      setSearchCriteria({
                        ...searchCriteria,
                        start_date: dates[0].format(DATE_FORMAT),
                        end_date: dates[1].format(DATE_FORMAT),
                      });
                    }
                  }}
                  value={date}
                />
              </Col>
            </>
          );
        }}
      />
    </>
  );
}

export default DailyAttendance;
