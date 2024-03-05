export function timeConversion(s) {
    const AMPM = s.slice(-2);
    const timeArr = s.slice(0, -2).split(":");

    if (AMPM === "AM" && timeArr[0] === "12") {
        timeArr[0] = "00";
    } else if (AMPM === "PM") {
        timeArr[0] = (timeArr[0] % 12) + 12;
    }

    return timeArr.join(":").replace(/\s+/g, '');
}

export function isValidDate(date) {
    return !isNaN(Date.parse(date));
}

export function padValue(value) {
    return value.toString().padStart( 2, '0' );
}