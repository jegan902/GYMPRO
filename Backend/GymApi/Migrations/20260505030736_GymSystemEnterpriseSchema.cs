using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace GymApi.Migrations
{
    /// <inheritdoc />
    public partial class GymSystemEnterpriseSchema : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "audit_logs",
                columns: table => new
                {
                    id = table.Column<long>(type: "bigint", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    table_name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    primary_key = table.Column<string>(type: "nvarchar(200)", maxLength: 200, nullable: false),
                    action = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    old_values = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    new_values = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    affected_columns = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    user_id = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    correlation_id = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_audit_logs", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "branches",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    address = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    phone = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: true),
                    manager_id = table.Column<int>(type: "int", maxLength: 100, nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_branches", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "diet_plans",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(150)", maxLength: 150, nullable: false),
                    goal = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    total_calories = table.Column<int>(type: "int", nullable: true),
                    protein_grams = table.Column<int>(type: "int", nullable: true),
                    carbs_grams = table.Column<int>(type: "int", nullable: true),
                    fat_grams = table.Column<int>(type: "int", nullable: true),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_diet_plans", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "equipments",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(150)", maxLength: 150, nullable: false),
                    category = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    purchase_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    last_maintenance_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    next_maintenance_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    quantity = table.Column<int>(type: "int", nullable: false),
                    note = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_equipments", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "home_features",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    icon = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    title = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    display_order = table.Column<int>(type: "int", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_home_features", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "home_page_hero",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    title = table.Column<string>(type: "nvarchar(200)", maxLength: 200, nullable: false),
                    subtitle = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    button_text = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    image_url = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    background_color = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_home_page_hero", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "muscle_groups",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    name_vi = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    icon = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_muscle_groups", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "packages",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    duration = table.Column<int>(type: "int", nullable: false),
                    price = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    features = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_packages", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "permissions",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    module = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: true),
                    description = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_permissions", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "roles",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    description = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_roles", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "settings",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    setting_key = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    setting_value = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    description = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_settings", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "workout_plans",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(150)", maxLength: 150, nullable: false),
                    level = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    days_per_week = table.Column<int>(type: "int", nullable: false),
                    goal = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_workout_plans", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "meals",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    diet_plan_id = table.Column<int>(type: "int", nullable: false),
                    meal_name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    food_items = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    calories = table.Column<int>(type: "int", nullable: true),
                    protein = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    carbs = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    fat = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    sort_order = table.Column<int>(type: "int", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_meals", x => x.id);
                    table.ForeignKey(
                        name: "FK_meals_diet_plans_diet_plan_id",
                        column: x => x.diet_plan_id,
                        principalTable: "diet_plans",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "exercises",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    muscle_group_id = table.Column<int>(type: "int", nullable: false),
                    name = table.Column<string>(type: "nvarchar(150)", maxLength: 150, nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    sets_recommended = table.Column<int>(type: "int", nullable: false),
                    reps_recommended = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    video_url = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    image_url = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    level = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    equipment = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_exercises", x => x.id);
                    table.ForeignKey(
                        name: "FK_exercises_muscle_groups_muscle_group_id",
                        column: x => x.muscle_group_id,
                        principalTable: "muscle_groups",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "role_permissions",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    role_id = table.Column<int>(type: "int", nullable: false),
                    permission_id = table.Column<int>(type: "int", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_role_permissions", x => x.id);
                    table.ForeignKey(
                        name: "FK_role_permissions_permissions_permission_id",
                        column: x => x.permission_id,
                        principalTable: "permissions",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_role_permissions_roles_role_id",
                        column: x => x.role_id,
                        principalTable: "roles",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "users",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    branch_id = table.Column<int>(type: "int", nullable: true),
                    role_id = table.Column<int>(type: "int", nullable: true),
                    full_name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    email = table.Column<string>(type: "nvarchar(150)", maxLength: 150, nullable: false),
                    password = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: false),
                    phone = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: true),
                    role = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    avatar = table.Column<string>(type: "nvarchar(255)", maxLength: 255, nullable: true),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    last_login = table.Column<DateTime>(type: "datetime2", nullable: true),
                    otp_code = table.Column<string>(type: "nvarchar(6)", maxLength: 6, nullable: true),
                    otp_expiry = table.Column<DateTime>(type: "datetime2", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_users", x => x.id);
                    table.ForeignKey(
                        name: "FK_users_branches_branch_id",
                        column: x => x.branch_id,
                        principalTable: "branches",
                        principalColumn: "id");
                    table.ForeignKey(
                        name: "FK_users_roles_role_id",
                        column: x => x.role_id,
                        principalTable: "roles",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "workout_sessions",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    workout_plan_id = table.Column<int>(type: "int", nullable: false),
                    day_number = table.Column<int>(type: "int", nullable: false),
                    session_name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    focus_area = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_workout_sessions", x => x.id);
                    table.ForeignKey(
                        name: "FK_workout_sessions_workout_plans_workout_plan_id",
                        column: x => x.workout_plan_id,
                        principalTable: "workout_plans",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "classes",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    name = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: false),
                    description = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    instructor_id = table.Column<int>(type: "int", nullable: true),
                    start_time = table.Column<DateTime>(type: "datetime2", nullable: false),
                    end_time = table.Column<DateTime>(type: "datetime2", nullable: false),
                    capacity = table.Column<int>(type: "int", nullable: false),
                    branch_id = table.Column<int>(type: "int", nullable: false),
                    is_active = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_classes", x => x.id);
                    table.ForeignKey(
                        name: "FK_classes_branches_branch_id",
                        column: x => x.branch_id,
                        principalTable: "branches",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_classes_users_instructor_id",
                        column: x => x.instructor_id,
                        principalTable: "users",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "members",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    user_id = table.Column<int>(type: "int", nullable: false),
                    date_of_birth = table.Column<DateTime>(type: "datetime2", nullable: true),
                    gender = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    height = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    weight = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    bmi = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    address = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    emergency_contact = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    emergency_phone = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: true),
                    join_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_members", x => x.id);
                    table.ForeignKey(
                        name: "FK_members_users_user_id",
                        column: x => x.user_id,
                        principalTable: "users",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "user_permissions",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    user_id = table.Column<int>(type: "int", nullable: false),
                    permission_id = table.Column<int>(type: "int", nullable: false),
                    is_granted = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_user_permissions", x => x.id);
                    table.ForeignKey(
                        name: "FK_user_permissions_permissions_permission_id",
                        column: x => x.permission_id,
                        principalTable: "permissions",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_user_permissions_users_user_id",
                        column: x => x.user_id,
                        principalTable: "users",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "workout_session_exercises",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    workout_session_id = table.Column<int>(type: "int", nullable: false),
                    exercise_id = table.Column<int>(type: "int", nullable: false),
                    sets = table.Column<int>(type: "int", nullable: false),
                    reps = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    rest_seconds = table.Column<int>(type: "int", nullable: false),
                    sort_order = table.Column<int>(type: "int", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_workout_session_exercises", x => x.id);
                    table.ForeignKey(
                        name: "FK_workout_session_exercises_exercises_exercise_id",
                        column: x => x.exercise_id,
                        principalTable: "exercises",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_workout_session_exercises_workout_sessions_workout_session_id",
                        column: x => x.workout_session_id,
                        principalTable: "workout_sessions",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "ai_reports",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    report_type = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    data = table.Column<string>(type: "NVARCHAR(MAX)", nullable: false),
                    generated_at = table.Column<DateTime>(type: "datetime2", nullable: false),
                    is_reviewed = table.Column<bool>(type: "bit", nullable: false),
                    reviewed_by = table.Column<int>(type: "int", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_ai_reports", x => x.id);
                    table.ForeignKey(
                        name: "FK_ai_reports_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_ai_reports_users_reviewed_by",
                        column: x => x.reviewed_by,
                        principalTable: "users",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "attendance",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    check_in_time = table.Column<DateTime>(type: "datetime2", nullable: false),
                    check_out_time = table.Column<DateTime>(type: "datetime2", nullable: true),
                    method = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_attendance", x => x.id);
                    table.ForeignKey(
                        name: "FK_attendance_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "class_bookings",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    class_id = table.Column<int>(type: "int", nullable: false),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    idempotency_key = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_class_bookings", x => x.id);
                    table.ForeignKey(
                        name: "FK_class_bookings_classes_class_id",
                        column: x => x.class_id,
                        principalTable: "classes",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_class_bookings_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "class_waitlists",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    class_id = table.Column<int>(type: "int", nullable: false),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    position = table.Column<int>(type: "int", nullable: false),
                    status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_class_waitlists", x => x.id);
                    table.ForeignKey(
                        name: "FK_class_waitlists_classes_class_id",
                        column: x => x.class_id,
                        principalTable: "classes",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_class_waitlists_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "exercise_logs",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    exercise_id = table.Column<int>(type: "int", nullable: false),
                    workout_session_id = table.Column<int>(type: "int", nullable: true),
                    set_number = table.Column<int>(type: "int", nullable: false),
                    reps = table.Column<int>(type: "int", nullable: false),
                    weight = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    log_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_exercise_logs", x => x.id);
                    table.ForeignKey(
                        name: "FK_exercise_logs_exercises_exercise_id",
                        column: x => x.exercise_id,
                        principalTable: "exercises",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_exercise_logs_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_exercise_logs_workout_sessions_workout_session_id",
                        column: x => x.workout_session_id,
                        principalTable: "workout_sessions",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "health_metrics",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    heart_rate = table.Column<int>(type: "int", nullable: true),
                    spo2 = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    bmi = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    bmr = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    muscle_mass = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    fat_percentage = table.Column<decimal>(type: "decimal(18,2)", nullable: true),
                    measurement_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_health_metrics", x => x.id);
                    table.ForeignKey(
                        name: "FK_health_metrics_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "member_diet_plans",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    diet_plan_id = table.Column<int>(type: "int", nullable: false),
                    assigned_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_member_diet_plans", x => x.id);
                    table.ForeignKey(
                        name: "FK_member_diet_plans_diet_plans_diet_plan_id",
                        column: x => x.diet_plan_id,
                        principalTable: "diet_plans",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_member_diet_plans_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "member_workout_plans",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    workout_plan_id = table.Column<int>(type: "int", nullable: false),
                    assigned_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_member_workout_plans", x => x.id);
                    table.ForeignKey(
                        name: "FK_member_workout_plans_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_member_workout_plans_workout_plans_workout_plan_id",
                        column: x => x.workout_plan_id,
                        principalTable: "workout_plans",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "notifications",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: true),
                    user_id = table.Column<int>(type: "int", nullable: true),
                    title = table.Column<string>(type: "nvarchar(200)", maxLength: 200, nullable: false),
                    message = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    type = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    is_read = table.Column<bool>(type: "bit", nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()")
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_notifications", x => x.id);
                    table.ForeignKey(
                        name: "FK_notifications_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id");
                    table.ForeignKey(
                        name: "FK_notifications_users_user_id",
                        column: x => x.user_id,
                        principalTable: "users",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "subscriptions",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    package_id = table.Column<int>(type: "int", nullable: false),
                    start_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    end_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    payment_status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_subscriptions", x => x.id);
                    table.ForeignKey(
                        name: "FK_subscriptions_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_subscriptions_packages_package_id",
                        column: x => x.package_id,
                        principalTable: "packages",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "trainer_bookings",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    trainer_id = table.Column<int>(type: "int", nullable: false),
                    start_date = table.Column<DateTime>(type: "datetime2", nullable: false),
                    end_date = table.Column<DateTime>(type: "datetime2", nullable: true),
                    total_sessions = table.Column<int>(type: "int", nullable: false),
                    remaining_sessions = table.Column<int>(type: "int", nullable: false),
                    price = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    status = table.Column<string>(type: "nvarchar(max)", nullable: false),
                    idempotency_key = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_trainer_bookings", x => x.id);
                    table.ForeignKey(
                        name: "FK_trainer_bookings_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_trainer_bookings_users_trainer_id",
                        column: x => x.trainer_id,
                        principalTable: "users",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Restrict);
                });

            migrationBuilder.CreateTable(
                name: "invoices",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    member_id = table.Column<int>(type: "int", nullable: false),
                    subscription_id = table.Column<int>(type: "int", nullable: true),
                    amount = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    notes = table.Column<string>(type: "nvarchar(max)", nullable: true),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_invoices", x => x.id);
                    table.ForeignKey(
                        name: "FK_invoices_members_member_id",
                        column: x => x.member_id,
                        principalTable: "members",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_invoices_subscriptions_subscription_id",
                        column: x => x.subscription_id,
                        principalTable: "subscriptions",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "payments",
                columns: table => new
                {
                    id = table.Column<int>(type: "int", nullable: false)
                        .Annotation("SqlServer:Identity", "1, 1"),
                    invoice_id = table.Column<int>(type: "int", nullable: false),
                    amount = table.Column<decimal>(type: "decimal(18,2)", nullable: false),
                    payment_method = table.Column<string>(type: "nvarchar(50)", maxLength: 50, nullable: false),
                    transaction_id = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    idempotency_key = table.Column<string>(type: "nvarchar(100)", maxLength: 100, nullable: true),
                    status = table.Column<string>(type: "nvarchar(20)", maxLength: 20, nullable: false),
                    created_at = table.Column<DateTime>(type: "datetime2", nullable: false, defaultValueSql: "GETDATE()"),
                    updated_at = table.Column<DateTime>(type: "datetime2", nullable: true, defaultValueSql: "GETDATE()"),
                    is_deleted = table.Column<bool>(type: "bit", nullable: false),
                    deleted_at = table.Column<DateTime>(type: "datetime2", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_payments", x => x.id);
                    table.ForeignKey(
                        name: "FK_payments_invoices_invoice_id",
                        column: x => x.invoice_id,
                        principalTable: "invoices",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateIndex(
                name: "IX_ai_reports_member_id",
                table: "ai_reports",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_ai_reports_reviewed_by",
                table: "ai_reports",
                column: "reviewed_by");

            migrationBuilder.CreateIndex(
                name: "IX_attendance_member_id",
                table: "attendance",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_class_bookings_class_id",
                table: "class_bookings",
                column: "class_id");

            migrationBuilder.CreateIndex(
                name: "IX_class_bookings_member_id",
                table: "class_bookings",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_class_waitlists_class_id",
                table: "class_waitlists",
                column: "class_id");

            migrationBuilder.CreateIndex(
                name: "IX_class_waitlists_member_id",
                table: "class_waitlists",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_classes_branch_id",
                table: "classes",
                column: "branch_id");

            migrationBuilder.CreateIndex(
                name: "IX_classes_instructor_id",
                table: "classes",
                column: "instructor_id");

            migrationBuilder.CreateIndex(
                name: "IX_exercise_logs_exercise_id",
                table: "exercise_logs",
                column: "exercise_id");

            migrationBuilder.CreateIndex(
                name: "IX_exercise_logs_member_id",
                table: "exercise_logs",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_exercise_logs_workout_session_id",
                table: "exercise_logs",
                column: "workout_session_id");

            migrationBuilder.CreateIndex(
                name: "IX_exercises_muscle_group_id",
                table: "exercises",
                column: "muscle_group_id");

            migrationBuilder.CreateIndex(
                name: "IX_health_metrics_member_id",
                table: "health_metrics",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_invoices_member_id",
                table: "invoices",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_invoices_subscription_id",
                table: "invoices",
                column: "subscription_id");

            migrationBuilder.CreateIndex(
                name: "IX_meals_diet_plan_id",
                table: "meals",
                column: "diet_plan_id");

            migrationBuilder.CreateIndex(
                name: "IX_member_diet_plans_diet_plan_id",
                table: "member_diet_plans",
                column: "diet_plan_id");

            migrationBuilder.CreateIndex(
                name: "IX_member_diet_plans_member_id",
                table: "member_diet_plans",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_member_workout_plans_member_id",
                table: "member_workout_plans",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_member_workout_plans_workout_plan_id",
                table: "member_workout_plans",
                column: "workout_plan_id");

            migrationBuilder.CreateIndex(
                name: "IX_members_user_id",
                table: "members",
                column: "user_id");

            migrationBuilder.CreateIndex(
                name: "IX_notifications_member_id",
                table: "notifications",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_notifications_user_id",
                table: "notifications",
                column: "user_id");

            migrationBuilder.CreateIndex(
                name: "IX_payments_invoice_id",
                table: "payments",
                column: "invoice_id");

            migrationBuilder.CreateIndex(
                name: "IX_role_permissions_permission_id",
                table: "role_permissions",
                column: "permission_id");

            migrationBuilder.CreateIndex(
                name: "IX_role_permissions_role_id",
                table: "role_permissions",
                column: "role_id");

            migrationBuilder.CreateIndex(
                name: "IX_subscriptions_member_id",
                table: "subscriptions",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_subscriptions_package_id",
                table: "subscriptions",
                column: "package_id");

            migrationBuilder.CreateIndex(
                name: "IX_trainer_bookings_member_id",
                table: "trainer_bookings",
                column: "member_id");

            migrationBuilder.CreateIndex(
                name: "IX_trainer_bookings_trainer_id",
                table: "trainer_bookings",
                column: "trainer_id");

            migrationBuilder.CreateIndex(
                name: "IX_user_permissions_permission_id",
                table: "user_permissions",
                column: "permission_id");

            migrationBuilder.CreateIndex(
                name: "IX_user_permissions_user_id",
                table: "user_permissions",
                column: "user_id");

            migrationBuilder.CreateIndex(
                name: "IX_users_branch_id",
                table: "users",
                column: "branch_id");

            migrationBuilder.CreateIndex(
                name: "IX_users_role_id",
                table: "users",
                column: "role_id");

            migrationBuilder.CreateIndex(
                name: "IX_workout_session_exercises_exercise_id",
                table: "workout_session_exercises",
                column: "exercise_id");

            migrationBuilder.CreateIndex(
                name: "IX_workout_session_exercises_workout_session_id",
                table: "workout_session_exercises",
                column: "workout_session_id");

            migrationBuilder.CreateIndex(
                name: "IX_workout_sessions_workout_plan_id",
                table: "workout_sessions",
                column: "workout_plan_id");
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "ai_reports");

            migrationBuilder.DropTable(
                name: "attendance");

            migrationBuilder.DropTable(
                name: "audit_logs");

            migrationBuilder.DropTable(
                name: "class_bookings");

            migrationBuilder.DropTable(
                name: "class_waitlists");

            migrationBuilder.DropTable(
                name: "equipments");

            migrationBuilder.DropTable(
                name: "exercise_logs");

            migrationBuilder.DropTable(
                name: "health_metrics");

            migrationBuilder.DropTable(
                name: "home_features");

            migrationBuilder.DropTable(
                name: "home_page_hero");

            migrationBuilder.DropTable(
                name: "meals");

            migrationBuilder.DropTable(
                name: "member_diet_plans");

            migrationBuilder.DropTable(
                name: "member_workout_plans");

            migrationBuilder.DropTable(
                name: "notifications");

            migrationBuilder.DropTable(
                name: "payments");

            migrationBuilder.DropTable(
                name: "role_permissions");

            migrationBuilder.DropTable(
                name: "settings");

            migrationBuilder.DropTable(
                name: "trainer_bookings");

            migrationBuilder.DropTable(
                name: "user_permissions");

            migrationBuilder.DropTable(
                name: "workout_session_exercises");

            migrationBuilder.DropTable(
                name: "classes");

            migrationBuilder.DropTable(
                name: "diet_plans");

            migrationBuilder.DropTable(
                name: "invoices");

            migrationBuilder.DropTable(
                name: "permissions");

            migrationBuilder.DropTable(
                name: "exercises");

            migrationBuilder.DropTable(
                name: "workout_sessions");

            migrationBuilder.DropTable(
                name: "subscriptions");

            migrationBuilder.DropTable(
                name: "muscle_groups");

            migrationBuilder.DropTable(
                name: "workout_plans");

            migrationBuilder.DropTable(
                name: "members");

            migrationBuilder.DropTable(
                name: "packages");

            migrationBuilder.DropTable(
                name: "users");

            migrationBuilder.DropTable(
                name: "branches");

            migrationBuilder.DropTable(
                name: "roles");
        }
    }
}
