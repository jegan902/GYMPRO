namespace GymApi.Entities
{
    public enum EquipmentStatus
    {
        Active = 0,               // Đang hoạt động
        UnderMaintenance = 1,     // Đang bảo trì
        Broken = 2,               // Hỏng hóc
        Disposed = 3,             // Đã thanh lý
        Idle = 4,                 // Chưa sử dụng
        MaintenanceRequired = 5,  // Cần bảo trì
        AwaitingParts = 6,        // Đang chờ linh kiện
        InspectionRequired = 7,   // Cần kiểm tra
        Scrapped = 8              // Đã hỏng/Thay thế
    }

    public enum EquipmentCategory
    {
        CardioEquipment = 1,
        StrengthMachine = 2,
        FreeWeight = 3,
        FunctionalTraining = 4,
        YogaEquipment = 5,
        MedicalEquipment = 6,
        LockerEquipment = 7,
        FacilityEquipment = 8,
        SecurityEquipment = 9,
        SmartDeviceIoT = 10,
        MaintenanceEquipment = 11
    }

    public enum ConditionLevel
    {
        New = 1,
        Good = 2,
        Fair = 3,
        Poor = 4,
        Critical = 5
    }

    public enum RiskLevel
    {
        Low = 1,
        Medium = 2,
        High = 3,
        Critical = 4
    }
}
