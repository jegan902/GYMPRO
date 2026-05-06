using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace GymApi.Migrations
{
    /// <inheritdoc />
    public partial class FinalEnterpriseSchema : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropColumn(
                name: "last_maintenance_date",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "next_maintenance_date",
                table: "equipments");

            migrationBuilder.RenameColumn(
                name: "quantity",
                table: "equipments",
                newName: "condition");

            migrationBuilder.RenameColumn(
                name: "purchase_date",
                table: "equipments",
                newName: "deleted_at");

            migrationBuilder.RenameColumn(
                name: "note",
                table: "equipments",
                newName: "qr_code");

            migrationBuilder.RenameColumn(
                name: "category",
                table: "equipments",
                newName: "updated_by");

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "users",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "users",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "user_permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "user_permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "trainer_bookings",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "trainer_bookings",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "subscriptions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "subscriptions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "roles",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "roles",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "role_permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "role_permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "permissions",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "payments",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "payments",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "packages",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "packages",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "members",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "members",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "invoices",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "invoices",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "health_metrics",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "health_metrics",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AlterColumn<DateTime>(
                name: "updated_at",
                table: "equipments",
                type: "datetime2",
                nullable: true,
                defaultValueSql: "GETDATE()",
                oldClrType: typeof(DateTime),
                oldType: "datetime2",
                oldDefaultValueSql: "GETDATE()");

            migrationBuilder.AlterColumn<int>(
                name: "status",
                table: "equipments",
                type: "int",
                nullable: false,
                oldClrType: typeof(string),
                oldType: "nvarchar(max)");

            migrationBuilder.AlterColumn<string>(
                name: "name",
                table: "equipments",
                type: "nvarchar(200)",
                maxLength: 200,
                nullable: false,
                oldClrType: typeof(string),
                oldType: "nvarchar(150)",
                oldMaxLength: 150);

            migrationBuilder.AddColumn<byte[]>(
                name: "RowVersion",
                table: "equipments",
                type: "rowversion",
                rowVersion: true,
                nullable: false,
                defaultValue: new byte[0]);

            migrationBuilder.AddColumn<string>(
                name: "barcode",
                table: "equipments",
                type: "nvarchar(max)",
                nullable: true);

            migrationBuilder.AddColumn<int>(
                name: "branch_id",
                table: "equipments",
                type: "int",
                nullable: false,
                defaultValue: 0);

            migrationBuilder.AddColumn<int>(
                name: "brand_id",
                table: "equipments",
                type: "int",
                nullable: true);

            migrationBuilder.AddColumn<int>(
                name: "category_id",
                table: "equipments",
                type: "int",
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "equipments",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<int>(
                name: "current_location_id",
                table: "equipments",
                type: "int",
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "description",
                table: "equipments",
                type: "nvarchar(max)",
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "device_code",
                table: "equipments",
                type: "nvarchar(50)",
                maxLength: 50,
                nullable: false,
                defaultValue: "");

            migrationBuilder.AddColumn<string>(
                name: "image_url",
                table: "equipments",
                type: "nvarchar(max)",
                nullable: true);

            migrationBuilder.AddColumn<bool>(
                name: "is_deleted",
                table: "equipments",
                type: "bit",
                nullable: false,
                defaultValue: false);

            migrationBuilder.AddColumn<int>(
                name: "supplier_id",
                table: "equipments",
                type: "int",
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "classes",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "classes",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "class_waitlists",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "class_waitlists",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "class_bookings",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "class_bookings",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "branches",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "branches",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "created_by",
                table: "ai_reports",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.AddColumn<string>(
                name: "updated_by",
                table: "ai_reports",
                type: "nvarchar(100)",
                maxLength: 100,
                nullable: true);

            migrationBuilder.CreateTable(
                name: "equipment_brands",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_brands", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "equipment_categories_dim",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    enum_value = table.Column<int>(type: "int", nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_categories_dim", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "equipment_location_history",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    branch_id = table.Column<int>(type: "int", nullable: false),
                    room = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    zone = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    floor = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    position = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    moved_at = table.Column<DateTime>(type: "datetime2", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_location_history", x => x.id);
                    table.ForeignKey(
                        name: "FK_equipment_location_history_branches_branch_id",
                        column: x => x.branch_id,
                        principalTable: "branches",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_equipment_location_history_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "equipment_media",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    media_type = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    url = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    is_primary = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_media", x => x.id);
                    table.ForeignKey(
                        name: "FK_equipment_media_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "equipment_purchase_history",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    purchase_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    purchase_price = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    warranty_expiry = table.Column<DateTime>(type: "datetime2", nullable: true),
                    invoice_number = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    quantity = table.Column<int>(type: "int", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_purchase_history", x => x.id);
                    table.ForeignKey(
                        name: "FK_equipment_purchase_history_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "equipment_smart_configs",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    is_smart_device = table.Column<bool>(type: "bit", nullable: false),
                    ble_mac_address = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    ip_address = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    firmware_version = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    usage_hours = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    supports_heart_rate = table.Column<bool>(type: "bit", nullable: false),
                    supports_spo2 = table.Column<bool>(type: "bit", nullable: false),
                    supports_ai_tracking = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_smart_configs", x => x.id);
                    table.ForeignKey(
                        name: "FK_equipment_smart_configs_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "equipment_specifications",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    weight = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    weight_unit = table.Column<string>(type: "nvarchar(10)", maxLength: 10, nullable: true),
                    max_weight = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    material = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    model = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    serial_number = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    additional_specs_json = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_specifications", x => x.id);
                    table.ForeignKey(
                        name: "FK_equipment_specifications_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "equipment_suppliers",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(200)", maxLength: 200, nullable: false),
                    phone = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: true),
                    email = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    address = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipment_suppliers", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "maintenance_logs",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    equipment_id = table.Column<int>(type: "int", nullable: false),
                    issue = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    repair_action = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    cost = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    performed_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    repaired_at = table.Column<DateTime>(type: "datetime2", nullable: false),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    created_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    updated_by = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_maintenance_logs", x => x.id);
                    table.ForeignKey(
                        name: "FK_maintenance_logs_equipments_equipment_id",
                        column: x => x.equipment_id,
                        principalTable: "equipments",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateIndex(
                name: "IX_equipments_branch_id",
                table: "equipments",
                column: "branch_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipments_brand_id",
                table: "equipments",
                column: "brand_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipments_category_id",
                table: "equipments",
                column: "category_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipments_current_location_id",
                table: "equipments",
                column: "current_location_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipments_supplier_id",
                table: "equipments",
                column: "supplier_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_location_history_branch_id",
                table: "equipment_location_history",
                column: "branch_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_location_history_equipment_id",
                table: "equipment_location_history",
                column: "equipment_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_media_equipment_id",
                table: "equipment_media",
                column: "equipment_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_purchase_history_equipment_id",
                table: "equipment_purchase_history",
                column: "equipment_id");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_smart_configs_ble_mac_address",
                table: "equipment_smart_configs",
                column: "ble_mac_address",
                unique: true,
                filter: "[ble_mac_address] IS NOT NULL");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_smart_configs_equipment_id",
                table: "equipment_smart_configs",
                column: "equipment_id",
                unique: true);

            migrationBuilder.CreateIndex(
                name: "IX_equipment_smart_configs_ip_address",
                table: "equipment_smart_configs",
                column: "ip_address");

            migrationBuilder.CreateIndex(
                name: "IX_equipment_specifications_equipment_id",
                table: "equipment_specifications",
                column: "equipment_id",
                unique: true);

            migrationBuilder.CreateIndex(
                name: "IX_maintenance_logs_equipment_id",
                table: "maintenance_logs",
                column: "equipment_id");

            migrationBuilder.CreateIndex(
                name: "IX_maintenance_logs_repaired_at",
                table: "maintenance_logs",
                column: "repaired_at");

            migrationBuilder.AddForeignKey(
                name: "FK_equipments_branches_branch_id",
                table: "equipments",
                column: "branch_id",
                principalTable: "branches",
                principalColumn: "id",
                onDelete: ReferentialAction.Restrict);

            migrationBuilder.AddForeignKey(
                name: "FK_equipments_equipment_brands_brand_id",
                table: "equipments",
                column: "brand_id",
                principalTable: "equipment_brands",
                principalColumn: "id",
                onDelete: ReferentialAction.Restrict);

            migrationBuilder.AddForeignKey(
                name: "FK_equipments_equipment_categories_dim_category_id",
                table: "equipments",
                column: "category_id",
                principalTable: "equipment_categories_dim",
                principalColumn: "id",
                onDelete: ReferentialAction.Restrict);

            migrationBuilder.AddForeignKey(
                name: "FK_equipments_equipment_location_history_current_location_id",
                table: "equipments",
                column: "current_location_id",
                principalTable: "equipment_location_history",
                principalColumn: "id",
                onDelete: ReferentialAction.Restrict);

            migrationBuilder.AddForeignKey(
                name: "FK_equipments_equipment_suppliers_supplier_id",
                table: "equipments",
                column: "supplier_id",
                principalTable: "equipment_suppliers",
                principalColumn: "id",
                onDelete: ReferentialAction.Restrict);
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_equipments_branches_branch_id",
                table: "equipments");

            migrationBuilder.DropForeignKey(
                name: "FK_equipments_equipment_brands_brand_id",
                table: "equipments");

            migrationBuilder.DropForeignKey(
                name: "FK_equipments_equipment_categories_dim_category_id",
                table: "equipments");

            migrationBuilder.DropForeignKey(
                name: "FK_equipments_equipment_location_history_current_location_id",
                table: "equipments");

            migrationBuilder.DropForeignKey(
                name: "FK_equipments_equipment_suppliers_supplier_id",
                table: "equipments");

            migrationBuilder.DropTable(
                name: "equipment_brands");

            migrationBuilder.DropTable(
                name: "equipment_categories_dim");

            migrationBuilder.DropTable(
                name: "equipment_location_history");

            migrationBuilder.DropTable(
                name: "equipment_media");

            migrationBuilder.DropTable(
                name: "equipment_purchase_history");

            migrationBuilder.DropTable(
                name: "equipment_smart_configs");

            migrationBuilder.DropTable(
                name: "equipment_specifications");

            migrationBuilder.DropTable(
                name: "equipment_suppliers");

            migrationBuilder.DropTable(
                name: "maintenance_logs");

            migrationBuilder.DropIndex(
                name: "IX_equipments_branch_id",
                table: "equipments");

            migrationBuilder.DropIndex(
                name: "IX_equipments_brand_id",
                table: "equipments");

            migrationBuilder.DropIndex(
                name: "IX_equipments_category_id",
                table: "equipments");

            migrationBuilder.DropIndex(
                name: "IX_equipments_current_location_id",
                table: "equipments");

            migrationBuilder.DropIndex(
                name: "IX_equipments_supplier_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "users");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "users");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "user_permissions");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "user_permissions");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "trainer_bookings");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "trainer_bookings");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "subscriptions");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "subscriptions");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "roles");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "roles");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "role_permissions");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "role_permissions");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "permissions");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "permissions");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "payments");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "payments");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "packages");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "packages");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "members");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "members");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "invoices");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "invoices");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "health_metrics");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "health_metrics");

            migrationBuilder.DropColumn(
                name: "RowVersion",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "barcode",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "branch_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "brand_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "category_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "current_location_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "description",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "device_code",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "image_url",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "is_deleted",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "supplier_id",
                table: "equipments");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "classes");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "classes");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "class_waitlists");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "class_waitlists");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "class_bookings");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "class_bookings");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "branches");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "branches");

            migrationBuilder.DropColumn(
                name: "created_by",
                table: "ai_reports");

            migrationBuilder.DropColumn(
                name: "updated_by",
                table: "ai_reports");

            migrationBuilder.RenameColumn(
                name: "updated_by",
                table: "equipments",
                newName: "category");

            migrationBuilder.RenameColumn(
                name: "qr_code",
                table: "equipments",
                newName: "note");

            migrationBuilder.RenameColumn(
                name: "deleted_at",
                table: "equipments",
                newName: "purchase_date");

            migrationBuilder.RenameColumn(
                name: "condition",
                table: "equipments",
                newName: "quantity");

            migrationBuilder.AlterColumn<DateTime>(
                name: "updated_at",
                table: "equipments",
                type: "datetime2",
                nullable: false,
                defaultValueSql: "GETDATE()",
                oldClrType: typeof(DateTime),
                oldType: "datetime2",
                oldNullable: true,
                oldDefaultValueSql: "GETDATE()");

            migrationBuilder.AlterColumn<string>(
                name: "status",
                table: "equipments",
                type: "nvarchar(max)",
                nullable: false,
                oldClrType: typeof(int),
                oldType: "int");

            migrationBuilder.AlterColumn<string>(
                name: "name",
                table: "equipments",
                type: "nvarchar(150)",
                maxLength: 150,
                nullable: false,
                oldClrType: typeof(string),
                oldType: "nvarchar(200)",
                oldMaxLength: 200);

            migrationBuilder.AddColumn<DateTime>(
                name: "last_maintenance_date",
                table: "equipments",
                type: "datetime2",
                nullable: true);

            migrationBuilder.AddColumn<DateTime>(
                name: "next_maintenance_date",
                table: "equipments",
                type: "datetime2",
                nullable: true);
        }
    }
}
